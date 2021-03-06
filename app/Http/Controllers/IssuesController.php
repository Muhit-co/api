<?php namespace Muhit\Http\Controllers;

use Auth;
use Authorizer;
use Carbon\Carbon;
use DB;
use Muhit\Http\Controllers\Controller;
use Muhit\Jobs\IssueRemoved;
use Muhit\Jobs\SendIssueSupportedEmail;
use Muhit\Jobs\TestQueue;
use Muhit\Models\District;
use Muhit\Models\Hood;
use Muhit\Models\Issue;
use Muhit\Models\IssueReport;
use Muhit\Models\User;
use Redis;
use Request;
use Storage;
use Slack;

class IssuesController extends Controller {

	/**
	 * creates a new issues
	 *
	 * @return json
	 * @author
	 **/
	public function postAdd() {
		$data = Request::all();

		if ($this->isApi) {
			$user_id = Authorizer::getResourceOwnerId();
		} else {
			$user_id = Auth::user()->id;
		}

		if (empty($user_id)) {
			if ($this->isApi) {
				return response()->api(403, 'Auth required', []);
			}
			return redirect('/login')
				->with('error', trans('issues.login_try_again'));
		}

		$required_fields = ['tags', 'title', 'problem', 'location', 'solution'];

		foreach ($required_fields as $key) {
			if (!isset($data[$key]) or empty($data[$key])) {
				if ($this->isApi) {
					return response()->api(400, 'Missing fields, ' . $key . ' is required', $data);
				}
				$message = ' "' . trans('issues.' . $key) . '" ' . trans('issues.is_required') . '.';
				return redirect('/issues/new')->with('warning', trans('issues.fill_form_try_again') . $message)->withInput();
			}
		}

		$check_duplicate = DB::table('issues')
			->where('user_id', $user_id)
			->where('title', $data['title'])
			->where('location', $data['location'])
			->first();

		if (!empty($check_duplicate)) {
			if ($this->isApi) {
				return response()->api(400, 'Duplicate request', []);
			}
			if (!empty($check_duplicate)) {
				return redirect('/issues/new')->with('warning', trans('issues.seems_already_existing') . $message)->withInput();
			} else {
				return redirect('/issues/view/' . $check_duplicate->id)->with('warning', trans('issues.seems_already_existing'));
			}
		}

		DB::beginTransaction();
		#save the issue;

		$issue = new Issue;
		$issue->user_id = $user_id;
		$issue->title = $data['title'];
		$issue->problem = $data['problem'];
		$issue->solution = $data['solution'];
		$issue->status = 'new';
		$issue->location = $data['location'];
		$issue->city_id = 0;
		$issue->district_id = 0;
		$issue->hood_id = 0;
		$issue->is_anonymous = ((isset($data['is_anonymous'])) ? $data['is_anonymous'] : 0);
		if (isset($data['coordinates'])) {
			$issue->coordinates = $data['coordinates'];
		}

		#lets figure out the location.
		$location_parts = explode(",", $data['location']);
		$hood = false;
		if (count($location_parts) === 3) {
			$hood = Hood::fromLocation($data['location']);
		}

		if ($hood === false or $hood === null or !isset($hood->id) or !isset($hood->city_id) or !isset($hood->district_id)) {
			DB::rollback();
			if ($this->isApi) {
				return response()->api(401, 'Cant get the hood information from the location provided.', ['data' => $data]);
			}
			return redirect('issues/new')
				->with('error', trans('issues.error_while_location'));
		}

		$issue->city_id = $hood->city_id;
		$issue->district_id = $hood->district_id;
		$issue->hood_id = $hood->id;

		try {
			$issue->save();
		} catch (Exception $e) {
			Log::error('IssuesController/postAdd/SavingIssue', (array) $e);
			DB::rollback();
			if ($this->isApi) {
				return response()->api(500, 'Error on saving the issue', $data);
			}
			return redirect('/issues/new')->with('error', trans('issues.error_saving_wait_try_again'))->withInput();

		}

		#save the tags
		if (!empty($data['tags']) and is_array($data['tags'])) {
			foreach ($data['tags'] as $tag) {
				try {
					DB::table('issue_tag')->insert([
						'issue_id' => $issue->id,
						'tag_id' => $tag,
						'created_at' => Carbon::now(),
						'updated_at' => Carbon::now(),
					]);
					Redis::incr('tag_issue_counter:' . $tag);
				} catch (Exception $e) {
					Log::error('IssuesController/postAdd/SavingTagRelation', (array) $e);
					DB::rollback();
					if ($this->isApi) {
						return response()->api(500, 'Error while saving the issue', $data);

					}
					return redirect('issues/new')->with('error', trans('issues.error_technical_team'));
				}
			}
		}

		#save the images
		if (!empty($data['images']) and is_array($data['images'])) {
			foreach ($data['images'] as $image) {
				try {
					$name = str_replace('.', '', microtime(true));
					Storage::put('issues/' . $name, base64_decode($image));
					DB::table('issue_images')->insert([
						'issue_id' => $issue->id,
						'image' => 'issues/' . $name,
						'created_at' => Carbon::now(),
						'updated_at' => Carbon::now(),
					]);
				} catch (Exception $e) {
					Log::error('IssuesController/postAdd/SavingTheImage', (array) $e);
				}
			}
		}

		try {
			DB::table('issue_updates')->insert([
				'user_id' => $user_id,
				'issue_id' => $issue->id,
				'old_status' => 'n/a',
				'new_status' => 'new',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			]);
		} catch (Exception $e) {
			Log::error('IssuesController/postAdd/SavingIssueUpdate', (array) $e);
		}

		DB::commit();

		Redis::incr('user_opened_issue_counter:' . $user_id);

		if ($this->isApi) {
			return response()->api(200, 'Issue saved', Issue::with('user', 'tags', 'images')->find($issue->id));

		}

		// Send a message to Slack webhoook
		Slack::attach( getSlackIssueAttachment($issue) )->send('New idea (' . $issue->id . ') on muhit.co');

		return redirect('/issues/view/' . $issue->id)->with('success', trans('issues.idea_saved'));

	}

	/**
	 * display a form for adding a new issue
	 *
	 * @return view
	 * @author gcg
	 */
	public function getNew() {
		if ($this->isApi) {
			return response()->api(401, 'This request is not supported for api', []);
		}

		$tags = DB::table('tags')->get();

		return response()->app(200, 'issues.new', ['tags' => $tags]);
	}

	/**
	 * get issues based on pagination and filters
	 *
	 * @return view
	 * @author Me
	 */
	public function getIssues($hood_id = null) {
		$issues = Issue::with('user', 'tags', 'images', 'comments.muhtar');

		// Gets all available districts. @TODO: separate into own (async) request
        //Get cities and districts in these cities order by city name and district issue count
        $query =
            'select distinct name, city_name, issue_count from(
                select d.name, city_issues.name as city_name, (select count(*) from issues issue where issue.district_id = d.id and issue.deleted_at is NULL) as issue_count
                from districts d
                join (select  i.city_id id, c.name , count(i.city_id) as icount from cities c join issues i on c.id = i.city_id  where i.deleted_at is NULL group by i.city_id, c.name order by icount desc
                ) city_issues
                on d.city_id = city_issues.id
                join issues i on d.id = i.district_id
                where i.deleted_at is NULL
                order by city_issues.icount desc, d.name asc
              ) subquery;';
        $all_districts = DB::select($query);

		$hood = null;
		$district = null;

		if ($hood_id != 'all') {
			if (!empty($hood_id)) {
				$hood = Hood::with('district.city')->find(Auth::user()->hood_id);
				$issues->where('hood_id', $hood->id);
			}

			if (empty($hood)) {
				if (Request::has('location')) {
					$hood = Hood::fromLocation(Request::get('location'));
					if (isset($hood) and isset($hood->id)) {
						$issues->where('hood_id', $hood->id);
					}
				} else if (Request::has('district')) {
					$district = District::fromName(Request::get('district'));
					if(isset($district) && isset($district->id)) {
						$issues->where('district_id', $district->id);
					}
				} else {
					if (Auth::check()) {
						if (isset(Auth::user()->hood_id) and !empty(Auth::user()->hood_id)) {
							$hood = Hood::with('district.city')->find(Auth::user()->hood_id);
							$issues->where('hood_id', $hood->id);
						}
					}
				}
			}
		}


		$o1 = 'id';
		$o2 = 'desc';

		if (Request::has('sort')) {
			$sort = Request::get('sort');
			if ($sort == 'popular') {
				$o1 = 'supporter_count';
			}
		}

		$issues->orderBy($o1, $o2);

		if (Request::has('map') and (int) Request::get('map') === 1) {
			$data = $issues->paginate(500);
			return $this->displayMapData($data);
		}

		if (Request::ajax()) {
			return view('partials.issues-list', ['issues' => $issues->paginate(20), 'hood' => $hood]);
		}

		if ($this->isApi) {
			return response()->api(200, 'Issues', $issues->toArray());
		}

		$latestUpdatedIssues = $this->getLatestUpdatedIssues($hood, $district);
		view()->share('pageTitle', 'Fikir listesi - ');
		session(['last_page' => Request::path()]);
		return response()->app(200, 'issues.list', ['issues' => $issues->paginate(20), 'issues_count' => $issues->count(), 'hood' => $hood , 'district' => $district, 'all_districts' => $all_districts, 'latestUpdatedIssues' => $latestUpdatedIssues]);

	}

	private function getLatestUpdatedIssues($hood = null, $district = null)
    {
        $hood_id = null;
        $district_id = null;
        if(isset($hood))
            $hood_id = $hood->id;
        if(isset($district))
            $district_id = $district->id;

        $query = 'select i.id,i.title,i.status, CONCAT(u.first_name ," ", u.last_name) as commenter, c.updated_at
            from issues i
            join comments c
            on i.id = c.issue_id
            join users u
            on c.user_id = u.id
            where (:district_id is NULL or i.district_id = :district_id_1)
            and (:hood_id is NULL or i.hood_id = :hood_id_1)
            and i.deleted_at is NULL
            order by c.updated_at desc
            limit 10';

        return DB::select($query, ['district_id' => $district_id,'district_id_1' => $district_id, 'hood_id' => $hood_id, 'hood_id_1' => $hood_id]);

    }

            /**
	 * returns json format of the issues for map datas
	 *
	 * @return json
	 * @author Me
	 */
	private function displayMapData($data = []) {
		$output = [];
		$output['type'] = 'FeatureCollection';
		$output['features'] = [];
		foreach ($data as $d) {
			if (!empty($d->coordinates) and count(explode(', ', $d->coordinates)) == 2) {
				$coordinates = null;
				foreach (explode(", ", $d->coordinates) as $c) {
					$coordinates[] = floatval($c);
				}
				$output['features'][] = [
					'type' => 'Feature',
					'properties' => [
						'status' => $d->status,
						'id' => $d->id,
					],
					'geometry' => [
						'type' => 'Point',
						'coordinates' => array_reverse($coordinates),
					],
				];
			}
		}

		return response()->json($output);
	}

	/**
	 * map issues
	 *
	 * @return json
	 * @author
	 **/
	public function getMap($hood_id = null) {
		$hood = null;
		$issues = Issue::with('user', 'tags', 'images')
			->orderBy('id', 'desc')
			->paginate(20);

		$response = [];

		if ($issues !== null) {
			$response = $issues->toArray();
		}

		if ($this->isApi) {
			return response()->api(200, 'Issues ', $response);
		}

		view()->share('pageTitle', 'Fikir Haritesi - ');
		session(['last_page' => Request::path()]);
		return response()->app(200, 'issues.map', ['issues' => $issues, 'active_tab' => 'map', 'hood' => $hood]);
	}
	/**
	 * search issues
	 *
	 * @return json
	 * @author
	 **/
	public function postSearch() {
	}

	/**
	 * issue detail
	 *
	 * @return json
	 * @author
	 **/
	public function getView($id = null) {
		$user_id = null;
		$user_district_id = null;

		if ($this->isApi) {
			$user_id = Authorizer::getResourceOwnerId();
		} else {
			if (Auth::check()) {
				$user_id = Auth::user()->id;

				if(Auth::user()->level == 6 && isset(Auth::user()->hood_id)) {
					$user_district_id = DB::table('hoods')
					->where('id', Auth::user()->hood_id)
					->value('district_id');
				}
			}
		}

		$issue = Issue::with('user', 'tags', 'images', 'updates', 'comments.muhtar')
			->find($id);

		if (null === $issue) {
			if ($this->isApi) {
				return response()->api(404, 'Issue not found', ['id' => $id]);
			}
			return response()->app(404, 'errors.notfound', ['msg' => 'Fikir bulunamadı, silinmiş olabilir?']);
		}

		if ($this->isApi) {
			return response()->api(200, 'Issue details: ', ['issue' => $issue->toArray()]);
		}
		session(['last_page' => Request::path()]);
		return response()->app(200, 'issues.show', ['issue' => $issue->toArray($user_id), 'user_district_id' => $user_district_id]);
	}

	/**
	 * get issues via tag
	 *
	 * @return json
	 * @author
	 **/
	public function getByTag($tag_id = null, $start = 0, $take = 20) {
		$hood = null;
		$issues = Issue::with('user', 'tags', 'images')
			->orderBy('id', 'desc')
			->skip($start)
			->take($take)
			->get();

		$response = [];

		if ($issues !== null) {
			$response = $issues->toArray();
		}

		if ($this->isApi) {
			return response()->api(200, 'Issues starting with: ' . $start, $response);
		}

		view()->share('pageTitle', 'Fikir Listesi - ');
		session(['last_page' => Request::path()]);
		return response()->app(200, 'issues.list', ['issues' => $response, 'hood' => $hood]);
	}

	/**
	 * get mine issues
	 *
	 * @return json
	 * @author
	 **/
	public function getCreated() {

		$hood = null;

		if (!Auth::check()) {
			return redirect('/')
				->with('error', trans('issues.login_try_again'));
		}
		$user_id = Auth::user()->id;

		$issues = Issue::with('user', 'tags', 'images')
			->where('user_id', $user_id);

		$o1 = 'id';
		$o2 = 'desc';
		$order = 'latest';
		if (Request::has('sort')) {
			$sort = Request::get('sort');
			if ($sort == 'popular') {
				$o1 = 'supporter_count';
				$order = 'popular';
			}
		}

		$issues->orderBy($o1, $o2);

		$response = [];

		if (Request::has('map') and (int) Request::get('map') === 1) {
			$data = $issues->paginate(20);
			return $this->displayMapData($data);
		}

		$issues = $issues->paginate(20);

		if ($issues !== null) {
			$response = $issues->toArray();
		}

		if ($this->isApi) {
			return response()->api(200, 'Issues starting with: ' . $start, $response);
		}

		view()->share('pageTitle', 'Fikir Listesi - ');
		session(['last_page' => Request::path()]);
		return response()->app(200, 'issues.created', ['issues' => $issues, 'order' => $order, 'hood' => $hood]);
	}

	/**
	 * get users supported issues
	 *
	 * @return json
	 * @author
	 **/
	public function getSupported($order = 'latest') {

		$hood = null;

		if (!Auth::check()) {
			return redirect('/')
				->with('error', 'Giriş yapıp tekrar deneyebilirsiniz.');
		}

		$issue_ids = DB::table('issue_supporters')->where('user_id', Auth::user()->id)->lists('issue_id');

		if (empty($issue_ids)) {
			return redirect('/')
				->with('error', trans('issues.no_supported_ideas_yet'));
		}

		$o = 'id';
		if ($order == 'popular') {
			$o = 'supporter_count';
		}

		$issues = Issue::with('user', 'tags', 'images')
			->whereIn('id', $issue_ids);

		$o1 = 'id';
		$o2 = 'desc';
		$order = 'latest';
		if (Request::has('sort')) {
			$sort = Request::get('sort');
			if ($sort == 'popular') {
				$o1 = 'supporter_count';
				$order = 'popular';
			}
		}

		$issues->orderBy($o1, $o2);

		if (Request::has('map') and (int) Request::get('map') === 1) {
			$data = $issues->paginate(20);
			return $this->displayMapData($data);
		}

		$issues = $issues->paginate(20);

		$response = [];

		if ($issues !== null) {
			$response = $issues->toArray();
		}

		if ($this->isApi) {
			return response()->api(200, 'Issues starting with: ' . $start, $response);
		}

		view()->share('pageTitle', 'Fikir Listesi - ');
		session(['last_page' => Request::path()]);
		return response()->app(200, 'issues.supported', ['issues' => $issues, 'order' => $order, 'hood' => $hood]);
	}

	/**
	 * deletes an issue
	 *
	 * @return mixed
	 * @author gcg
	 */
	public function getDelete($id = null) {
		if ($this->isApi) {
			$user_id = Authorizer::getResourceOwnerId();
		} else {
			$user_id = Auth::user()->id;
		}

		if (empty($user_id)) {
			if ($this->isApi) {
				return response()->api(403, 'Auth required', []);
			}
			return redirect('/login')
				->with('error', trans('issues.login_try_again'));
		}

		$issue = Issue::find($id);

		if ($issue === null) {
			if ($this->isApi) {
				return response()->api(404, 'Issue not found', []);
			}
			return redirect('/issues')
				->with('error', trans('issues.delete_couldnt_find'));
		}

		$can_delete = false;
		$user_id = (int) $user_id;
		if ($user_id === $issue->user_id) {
			$can_delete = true;
		} else {
			$user_level = (int) DB::table('users')
				->where('id', $user_id)
				->value('level');
			if ($user_level > 5) {
				$can_delete = true;
			}
		}

		if ($can_delete === false) {

			if ($this->isApi) {
				return response()->api(403, 'You are not authorized to delete this issue');
			}
			return redirect('/issues/view/' . $id)
				->with('error', trans('issues.delete_not_authorised'));

		}

		if ($issue->status != 'new' or (int) Redis::get('supporter_counter:' . $issue->id) > 10) {
			if ($this->isApi) {
				return response()->api(403, 'You are not authorized to delete this issue');
			}
			return redirect('/issues/view/' . $id)
				->with('error', trans('issues.delete_nostatus'));
		}

		try {
			$issue->delete();
			DB::table('issue_updates')
				->insert([
					'user_id' => $user_id,
					'issue_id' => $id,
					'old_status' => $issue->status,
					'new_status' => 'deleted',
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now(),
				]);
			if($user_id !== $issue->user_id) {
				$this->dispatch(new IssueRemoved($id));
			}
		} catch (Exception $e) {
			Log::error('IssuesController/getDelete', (array) $e);
			if ($this->isApi) {
				return response()->api(500, 'Tech problem while deleting the issue', []);
			}
			return redirect('/issues')
				->with('error', trans('issues.error_while_supporting'));
		}

		if ($this->isApi) {
			return response()->api(200, 'Issue deleted.', ['id' => $id]);
		}
		return redirect('/issues')
			->with('success', trans('issues.delete_success'));
	}

	/**
	 * support an issue
	 *
	 * @return mixed
	 * @author gcg
	 */
	public function getSupport($id = null) {

		if ($this->isApi) {
			$user_id = Authorizer::getResourceOwnerId();
		} else {
			$user_id = Auth::user()->id;
		}

		if (empty($user_id)) {
			if ($this->isApi) {
				return response()->api(403, 'Auth required', []);
			}
			return redirect('/login')
				->with('error', trans('issues.login_try_again'));
		}

		$issue = Issue::find($id);

		if ($issue === null) {
			if ($this->isApi) {
				return response()->api(404, 'Issue not found', []);
			}
			return redirect('/issues')
				->with('error', trans('issues.delete_couldnt_find'));
		}

		$check = (int) DB::table('issue_supporters')
			->where('user_id', $user_id)
			->where('issue_id', $issue->id)
			->count();

		if ($check > 0) {
			if ($this->isApi) {
				return response()->api(200, 'Already supported', []);
			}
			return redirect('/issues/view/' . $id)
				->with('warning', trans('issues.already_support_idea'));
		}

		try {
			DB::table('issue_supporters')
				->insert([
					'user_id' => $user_id,
					'issue_id' => $id,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now(),
				]);
			Redis::incr('user_supported_issue_counter:' . $user_id);
			DB::table('issues')->where('id', $id)->increment('supporter_count');
			$su_counter = (int) Redis::incr('supporter_counter:' . $id);
            Redis::zadd('issue_supporters:' . $id, time(), $user_id);

            // for some reason if the counter on redis falls behind, lets make it catch up.
            $db_counter = $issue->supporter_count + 1;
            $this->syncCounter($id, $su_counter, $db_counter);

			$this->dispatch(new SendIssueSupportedEmail($user_id, $id));
		} catch (Exception $e) {
			Log::error('IssuesController/getSupport', (array) $e);
			if ($this->isApi) {
				return response()->api(500, 'Tech problem while supporting the issue', []);
			}
			return redirect('/issues/view/' . $id)
				->with('error', trans('issues.error_while_supporting'));
		}

		if ($this->isApi) {
			return response()->api(200, 'Issue supported', ['current_supporter_counter' => $su_counter, 'issue_id' => $id]);
		}

		return redirect('/issues/view/' . $id)
			->with('success', trans('issues.idea_supported'));

	}

	/**
	 * un-support an issue
	 *
	 * @return mixed
	 * @author gcg
	 */
	public function getUnSupport($id = null) {
		if ($this->isApi) {
			$user_id = Authorizer::getResourceOwnerId();
		} else {
			$user_id = Auth::user()->id;
		}

		if (empty($user_id)) {
			if ($this->isApi) {
				return response()->api(403, 'Auth required', []);
			}
			return redirect('/login')
				->with('error', trans('issues.login_try_again'));
		}

		$issue = Issue::find($id);

		if ($issue === null) {
			if ($this->isApi) {
				return response()->api(404, 'Issue not found', []);
			}
			return redirect('/issues')
				->with('error', trans('issues.delete_couldnt_find'));
		}

		$check = DB::table('issue_supporters')
			->where('user_id', $user_id)
			->where('issue_id', $issue->id)
			->first();

		if (empty($check)) {
			if ($this->isApi) {
				return response()->api(200, 'User did not support this issue', []);
			}
			return redirect('/issues/view/' . $id)
				->with('warning', trans('issues.dont_support'));
		}

		try {
			DB::table('issue_supporters')
				->where('id', $check->id)
				->delete();

			Redis::decr('user_supported_issue_counter:' . $user_id);
			$su_counter = (int) Redis::decr('supporter_counter:' . $id);
            Redis::zrem('issue_supporters:' . $id, $user_id);

			DB::table('issues')->where('id', $id)->decrement('supporter_count');
            $db_counter = $issue->supporter_count - 1;
            $this->syncCounter($id, $su_counter, $db_counter);
		} catch (Exception $e) {
			Log::error('IssuesController/getUnSupport', (array) $e);
			if ($this->isApi) {
				return response()->api(500, 'Tech problem while unsupporting the issue', []);
			}
			return redirect('/issues/view/' . $id)
				->with('error', trans('issues.error_while_supporting'));
		}

		if ($this->isApi) {
			return response()->api(200, 'Issue un-supported', ['current_supporter_counter' => $su_counter, 'issue_id' => $id]);
		}

		return redirect('/issues/view/' . $id)
			->with('success', trans('issues.dont_support_anymore'));

	}

	/**
	 * get supporter list for an issue
	 *
	 * @return mixed
	 * @author gcg
	 */
	public function getSupporters($id = null, $start = 0, $take = 20) {
		$issue = Issue::find($id);

		if ($issue === null) {
			if ($this->isApi) {
				return response()->api(404, 'Issue not found', []);
			}
			return redirect('/issues')
				->with('error', trans('issues.idea_not_found'));
		}

		$supporter_ids = [];
		$supporter_ids = DB::table('issue_supporters')
			->where('issue_id', $issue->id)
			->orderBy('created_at', 'desc')
			->skip($start)
			->take($take)
			->lists('user_id');

		$users = [];

		if (!empty($supporter_ids)) {
			$users = User::whereIn('id', $supporter_ids)
				->get();

			if (!empty($users)) {
				$users = $users->toArray();
			}
		}

		if ($this->isApi) {
			return response()->api(200, 'List of issue supporters: ' . $id, $users);
		}
		session(['last_page' => Request::path()]);
		return response()->app(200, 'issues.supporters', ['users' => $users]);

	}

	/**
	 * submits a report for an issue
	 *
	 * @return redirect
	 * @author Me
	 */
	public function postReport() {

		if (!Auth::check()) {
			return redirect('/login')
				->with('error', trans('issues.login_try_again'));
		}

		if (!Request::has('issue_id') or !Request::has('feedback')) {
			return redirect('/')
				->with('error', trans('issues.login_try_again'));
		}

		$data = Request::all();

		$r = new IssueReport;

		$r->issue_id = $data['issue_id'];
		$r->user_id = Auth::user()->id;
		$r->feedback = $data['feedback'];

		try {
			$r->save();
		} catch (Exception $e) {
			Log::error('IssuesController/postReport', (array) $e);
			return redirect('/issues/view/' . $data['issue_id'])
				->with('error', trans('issues.feedback_error'));
		}

		return redirect('/issues/view/' . $data['issue_id'])
			->with('success', trans('issues.feedback_thankyou'));
	}

	/**
	 * foo
	 *
	 * @return void
	 * @author Me
	 */
	public function testqueue() {
		$this->dispatch(new TestQueue());
    }

    private function syncCounter($id, $redis_counter, $db_counter)
    {
        if ($redis_counter !== $db_counter) {
            $db_counter = $db_counter < 0 ? 0 : $db_counter;
            Redis::set('supporter_counter:'.$id, $db_counter);
        }
        return;
    }
}
