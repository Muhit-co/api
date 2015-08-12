<?php namespace Muhit\Http\Controllers;

use Authorizer;
use Carbon\Carbon;
use DB;
use Muhit\Http\Controllers\Controller;
use Muhit\Models\Issue;
use Muhit\Models\IssueSupporter;
use Muhit\Models\IssueReport;
use Muhit\Models\City;
use Muhit\Models\District;
use Muhit\Models\Hood;
use Muhit\Models\User;
use Redis;
use Request;
use Storage;
use Auth;

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
        }
        else {
            $user_id = Auth::user()->id;
        }

        if (empty($user_id)) {
            if ($this->isApi) {
                return response()->api(403, 'Auth required', []);
            }
            return redirect('/login')
                ->with('error', 'Lütfen giriş yapıp tekrar deneyin. ');
        }


        $required_fields = ['tags', 'title', 'problem', 'location', 'solution'];

        foreach ($required_fields as $key) {
            if (!isset($data[$key]) or empty($data[$key])) {
                if ($this->isApi) {
                    return response()->api(400, 'Missing fields, ' . $key . ' is required', $data);
                }
                return redirect('/issues/new')->with('warning', 'Lütfen tüm formu doldurup tekrar deneyin. '.$key);
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
            return redirect('/issues/view/'.$check_duplicate->id)
                ->with('warning', 'Daha önceden açtığınız bir fikri tekrar açmak istiyorsunuz gibi.');
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
                ->with('error', 'Lokasyonunuzu girerken bir hata oldu, lütfen tekrar deneyin.');
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
            return redirect('/issues/new')->with('error', 'Fikrinizi kaydederken teknik bir hata meydana geldi, lütfen biraz bekleyip tekrar deneyin.');

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
                        return response()->api(500, 'Error on saving the issue', $data);

                    }
                    return redirect('issues/new')->with('error', 'Fikrinizi kaydederken teknik bir hata geldi, hata logu teknik ekibe iletildi. Hemen ilgileniyoruz');
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

        Redis::incr('user_opened_issue_counter:'.$user_id);

        if ($this->isApi) {
            return response()->api(200, 'Issue saved', Issue::with('user', 'tags', 'images')->find($issue->id));

        }

        return redirect('/issues')->with('success', 'Fikrinizi kaydettik');


    }

    /**
     * display a form for adding a new issue
     *
     * @return view
     * @author gcg
     */
    public function getNew()
    {
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
    public function getIssues($hood_id = null)
    {
        $issues = Issue::with('user', 'tags', 'images');

        $hood = null;

        if ($hood_id != 'all') {
            if (!empty($hood_id)) {
                $hood = Hood::with('district.city')->find(Auth::user()->hood_id);
            }


            if (empty($hood)) {
                if (Request::has('location')) {
                    $hood = Hood::fromLocation(Request::get('location'));
                    if (isset($hood) and isset($hood->id)) {
                        $issues->where('hood_id', $hood->id);
                    }
                }
                else {
                    if (Auth::check()) {
                        if (isset(Auth::user()->hood_id) and !empty(Auth::user()->hood_id)) {
                            $hood = Hood::with('district.city')->find(Auth::user()->hood_id);
                            $issues->where('hood_id', $hood_id);
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


        if (Request::ajax()) {
            return view('partials.issues', ['issues' => $issues->paginate(20), 'hood' => $hood]);
        }

        if ($this->isApi) {
            return response()->api(200, 'Issues', $issues->toArray());
        }

        view()->share('pageTitle', 'Fikir listesi - ');
        return response()->app(200, 'issues.list', ['issues' => $issues->paginate(20), 'hood' => $hood]);

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
        $issue = Issue::with('user', 'tags', 'images', 'updates')
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
        return response()->app(200, 'issues.show', ['issue' => $issue->toArray()]);
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
                ->with('error', 'Giriş yapıp tekrar deneyebilirsiniz.');
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

        $issues = $issues->paginate(20);

        if ($issues !== null) {
            $response = $issues->toArray();
        }

        if ($this->isApi) {
            return response()->api(200, 'Issues starting with: ' . $start, $response);
        }

        view()->share('pageTitle', 'Fikir Listesi - ');
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
                ->with('error', 'Henüz hiç bir fikri desteklememişsiniz.');
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

        $issues = $issues->paginate(20);

        $response = [];

        if ($issues !== null) {
            $response = $issues->toArray();
        }

        if ($this->isApi) {
            return response()->api(200, 'Issues starting with: ' . $start, $response);
        }

        view()->share('pageTitle', 'Fikir Listesi - ');
        return response()->app(200, 'issues.created', ['issues' => $issues, 'order' => $order, 'hood' => $hood]);
    }




    /**
     * deletes an issue
     *
     * @return mixed
     * @author gcg
     */
    public function getDelete($id = null)
    {
        if ($this->isApi) {
            $user_id = Authorizer::getResourceOwnerId();
        }
        else {
            $user_id = Auth::user()->id;
        }

        if (empty($user_id)) {
            if ($this->isApi) {
                return response()->api(403, 'Auth required', []);
            }
            return redirect('/login')
                ->with('error', 'Lütfen giriş yapıp tekrar deneyin. ');
        }

        $issue = Issue::find($id);

        if ($issue === null) {
            if ($this->isApi) {
                return response()->api(404, 'Issue not found', []);
            }
            return redirect('/issues')
                ->with('error', 'Silmek istediğiniz fikiri bulamadım.');
        }

        $can_delete = false;
        $user_id = (int) $user_id;
        if ($user_id === $issue->user_id) {
            $can_delete = true;
        }
        else {
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
            return redirect('/issues/view/'.$id)
                ->with('error', 'Fikri silmek için yeterli yetkiniz yok.');

        }

        if ($issue->status != 'new' or (int) Redis::get('supporter_counter:'.$issue->id) > 10) {
            if ($this->isApi) {
                return response()->api(403, 'You are not authorized to delete this issue');
            }
            return redirect('/issues/view/'.$id)
                ->with('error', 'Issue silinebilir durumda değil. ');
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
                    'updated_at' => Carbon::now()
                ]);
        } catch (Exception $e) {
            Log::error('IssuesController/getDelete', (array) $e);
            if ($this->isApi) {
                return response()->api(500, 'Tech problem while deleting the issue', []);
            }
            return redirect('/issues')
                ->with('error', 'Fikrinizi silmeye çalışırken teknik bir hata meydana geldi.');
        }

        if ($this->isApi) {
            return response()->api(200, 'Issue deleted.', ['id' => $id]);
        }
        return redirect('/issues')
            ->with('success', 'Fikriniz başarılı bir şekilde silindi. ');
    }

    /**
     * support an issue
     *
     * @return mixed
     * @author gcg
     */
    public function getSupport($id = null)
    {
        if ($this->isApi) {
            $user_id = Authorizer::getResourceOwnerId();
        }
        else {
            $user_id = Auth::user()->id;
        }

        if (empty($user_id)) {
            if ($this->isApi) {
                return response()->api(403, 'Auth required', []);
            }
            return redirect('/login')
                ->with('error', 'Lütfen giriş yapıp tekrar deneyin. ');
        }

        $issue = Issue::find($id);

        if ($issue === null) {
            if ($this->isApi) {
                return response()->api(404, 'Issue not found', []);
            }
            return redirect('/issues')
                ->with('error', 'Silmek istediğiniz fikiri bulamadım.');
        }

        $check = (int) DB::table('issue_supporters')
            ->where('user_id', $user_id)
            ->where('issue_id', $issue->id)
            ->count();

        if ($check > 0) {
            if ($this->isApi) {
                return response()->api(200, 'Already supported', []);
            }
            return redirect('/issues/view/'.$id)
                ->with('warning', 'Bu fikri zaten destekliyorsunuz.');
        }

        try {
            DB::table('issue_supporters')
                ->insert([
                    'user_id' => $user_id,
                    'issue_id' => $id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            Redis::incr('user_supported_issue_counter:'.$user_id);
            DB::table('issues')->where('id', $id)->increment('supporter_count');
            $su_counter = (int) Redis::incr('supporter_counter:'.$id);
        } catch (Exception $e) {
            Log::error('IssuesController/getSupport', (array) $e);
            if ($this->isApi) {
                return response()->api(500, 'Tech problem while supporting the issue', []);
            }
            return redirect('/issues/view/'.$id)
                ->with('error', 'Fikri desteklerken teknik bir hata meydana geldi. Lütfen tekrar deneyin.');
        }

        if ($this->isApi) {
            return response()->api(200, 'Issue supported', ['current_supporter_counter' => $su_counter, 'issue_id' => $id]);
        }

        return redirect('/issues/view/'.$id)
            ->with('success', 'Fikir desteklendi.');

    }


    /**
     * un-support an issue
     *
     * @return mixed
     * @author gcg
     */
    public function getUnSupport($id = null)
    {
        if ($this->isApi) {
            $user_id = Authorizer::getResourceOwnerId();
        }
        else {
            $user_id = Auth::user()->id;
        }

        if (empty($user_id)) {
            if ($this->isApi) {
                return response()->api(403, 'Auth required', []);
            }
            return redirect('/login')
                ->with('error', 'Lütfen giriş yapıp tekrar deneyin. ');
        }

        $issue = Issue::find($id);

        if ($issue === null) {
            if ($this->isApi) {
                return response()->api(404, 'Issue not found', []);
            }
            return redirect('/issues')
                ->with('error', 'Silmek istediğiniz fikiri bulamadım.');
        }

        $check = DB::table('issue_supporters')
            ->where('user_id', $user_id)
            ->where('issue_id', $issue->id)
            ->first();

        if (empty($check)) {
            if ($this->isApi) {
                return response()->api(200, 'User did not support this issue', []);
            }
            return redirect('/issues/view/'.$id)
                ->with('warning', 'Bu fikri desteklemiyorsunuz.');
        }

        try {
            DB::table('issue_supporters')
                ->where('id', $check->id)
                ->delete();

            Redis::decr('user_supported_issue_counter:'.$user_id);
            $su_counter = (int) Redis::decr('supporter_counter:'.$id);
        } catch (Exception $e) {
            Log::error('IssuesController/getUnSupport', (array) $e);
            if ($this->isApi) {
                return response()->api(500, 'Tech problem while unsupporting the issue', []);
            }
            return redirect('/issues/view/'.$id)
                ->with('error', 'Fikri desteklerken teknik bir hata meydana geldi. Lütfen tekrar deneyin.');
        }

        if ($this->isApi) {
            return response()->api(200, 'Issue un-supported', ['current_supporter_counter' => $su_counter, 'issue_id' => $id]);
        }

        return redirect('/issues/view/'.$id)
            ->with('success', 'Bu fikri artık desteklemiyorsunuz');

    }



    /**
     * get supporter list for an issue
     *
     * @return mixed
     * @author gcg
     */
    public function getSupporters($id = null, $start = 0, $take = 20)
    {
        $issue = Issue::find($id);

        if ($issue === null) {
            if ($this->isApi) {
                return response()->api(404, 'Issue not found', []);
            }
            return redirect('/issues')
                ->with('error', 'Fikir bulunamadı.');
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
            return response()->api(200, 'List of issue supporters: '.$id, $users);
        }

        return response()->app(200, 'issues.supporters', ['users' => $users]);

    }

    /**
     * submits a report for an issue
     *
     * @return redirect
     * @author Me
     */
    public function postReport()
    {

        if (!Auth::check()) {
            return redirect('/login')
             ->with('error', 'Lütfen giriş yapıp tekrar deneyin.');
        }

        if (!Request::has('issue_id') or !Request::has('feedback')) {
            return redirect('/')
                ->with('error', 'Lütfen feedback girip tekrar deneyin.');
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
            return redirect('/issues/view/'.$data['issue_id'])
                ->with('error', 'Geribildiriminizi kaydederken teknik bir hata meydana geldi. Geliştirici ekibimiz konu hakkında uyarıldı.');
        }

        return redirect('/issues/view/'.$data['issue_id'])
            ->with('success', 'Geri bildiriminiz için teşekkürler.');
    }
}
