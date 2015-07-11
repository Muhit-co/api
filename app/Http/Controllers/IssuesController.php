<?php namespace Muhit\Http\Controllers;

use Authorizer;
use Carbon\Carbon;
use DB;
use Muhit\Http\Controllers\Controller;
use Muhit\Models\Issue;
use Muhit\Models\City;
use Muhit\Models\District;
use Muhit\Models\Hood;
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


        $required_fields = ['tags', 'title', 'desc', 'location'];

        foreach ($required_fields as $key) {
            if (!isset($data[$key]) or empty($data[$key])) {
                if ($this->isApi) {
                    return response()->api(400, 'Missing fields, ' . $key . ' is required', $data);
                }
                return redirect('/issues/new')->with('warning', 'Lütfen tüm formu doldurup tekrar deneyin.');
            }
        }


        DB::beginTransaction();
        #save the issue;

        $issue = new Issue;
        $issue->user_id = $user_id;
        $issue->title = $data['title'];
        $issue->desc = $data['desc'];
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
        if (count($location_parts) === 3) {
            try {
                $city = City::firstOrCreate(['name' => $location_parts[2]]);
                $issue->city_id = $city->id;
            } catch (Exception $e) {
                Log::error('IssuesController/city', (array) $e);
                DB::rollback();
                if ($this->isApi) {
                    return response()->api(500, 'Error on saving the city. ', []);
                }
                return redirect('/issues/new')
                    ->with('error', 'Fikrinizi kaydederken teknik bir hata meydana geldi. ');
            }

            try {
                $district = District::firstOrCreate(['name' => $location_parts[1], 'city_id' => $city->id]);
                $issue->district_id = $district->id;
            } catch (Exception $e) {
                Log::error('IssuesController/district', (array) $e);
                DB::rollback();
                if ($this->isApi) {
                    return response()->api(500, 'Error on saving the district. ', []);
                }
                return redirect('/issues/new')
                    ->with('error', 'Fikrinizi kaydederken teknik bir hata meydana geldi. ');
            }

            try {
                $hood = Hood::firstOrCreate([
                    'name' => $location_parts[0],
                    'city_id' => $city->id,
                    'district_id' => $district->id]);
                $issue->hood_id = $hood->id;
            } catch (Exception $e) {
                Log::error('IssuesController/district', (array) $e);
                DB::rollback();
                if ($this->isApi) {
                    return response()->api(500, 'Error on saving the district. ', []);
                }
                return redirect('/issues/new')
                    ->with('error', 'Fikrinizi kaydederken teknik bir hata meydana geldi. ');
            }
        }


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
     * list issues
     *
     * @return json
     * @author
     **/
    public function getList($start = 0, $take = 20) {
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
        return response()->app(200, 'issues.list', ['issues' => $response]);
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
        $issue = Issue::with('user', 'tags', 'images')
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
     * get popular issues via paginate
     *
     * @return json
     * @author
     **/
    public function getPopular($start = 0, $take = 20) {

    }

    /**
     * get latest issues via paginate
     *
     * @return json
     * @author
     **/
    public function getLatest($start = 0, $take = 20) {

    }

    /**
     * get issues via tag
     *
     * @return json
     * @author
     **/
    public function getByTag($tag_id = null, $start = 0, $take = 20) {

    }

    /**
     * get issues by hood
     *
     * @return json
     * @author
     **/
    public function getByHood($hood_id = null, $start = 0, $take = 20) {
    }

    /**
     * get issues by district
     *
     * @return json
     * @author
     **/
    public function getByDistrict($district_id = null, $start = 0, $take = 20) {
    }

    /**
     * get issues by city
     *
     * @return json
     * @author
     **/
    public function getByCity($city_id = null, $start = 0, $take = 20) {
    }

    /**
     * get issues by user
     *
     * @return json
     * @author
     **/
    public function getByUser($user_id = null, $start = 0, $take = 20) {
    }

    /**
     * get issues by status
     *
     * @return json
     * @author
     **/
    public function getByStatus($status = null, $start = 0, $take = 20) {
    }

    /**
     * get issues by sporter id
     *
     * @return json
     * @author
     **/
    public function getBySupporter($user_id = null, $start = 0, $take = 20) {
    }


}
