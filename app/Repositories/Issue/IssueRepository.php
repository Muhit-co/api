<?php

namespace Muhit\Repositories\Issue;

use Date;
use DB;
use Exception;
use Illuminate\Http\Request;
use Log;
use Muhit\Models\Hood;
use Muhit\Models\Issue;
use Muhit\Models\User;
use Redis;
use Storage;

class IssueRepository implements IssueRepositoryInterface
{
    protected $issue;
    protected $hood;
    private $user;

    public function __construct(Issue $issue, Hood $hood, User $user)
    {
        $this->issue = $issue;
        $this->hood = $hood;
        $this->user = $user;
    }

    public function all(Request $request, $start, $end)
    {
        $issues = $this->issue->with('user', 'tags', 'images')
            ->orderBy('id', 'desc')
            ->skip($start)
            ->take($end)
            ->get();

        return response()->api(200, 'Issues', $issues);
    }

    public function get(Request $request, $id)
    {
        $issue = $this->issue->with('user', 'tags', 'images', 'comments.muhtar')->find($id);

        if (!$issue) {

            return response()->api(401, 'Issue not found', []);
        }

        return response()->api(200, 'Issue', $issue);
    }

    public function create(Request $request)
    {
        $user_id = $request->get('user_id');
        $title = $request->get('title');
        $location = $request->get('location');

        if ($this->checkDuplicate($user_id, $title, $location) > 0) {

            return response()->api(401, 'Issue already exists', []);
        }

        try {

            DB::beginTransaction();

            $location_parts = explode(",", $location);
            $hood = false;

            if (count($location_parts) === 3) {
                $hood = Hood::fromLocation($location);
            }

            if ($hood === false or $hood === null or !isset($hood->id) or !isset($hood->city_id) or !isset($hood->district_id)) {

                DB::rollBack();

                return response()->api(401, 'Cant get the hood information from the location .', ['data' => $request->all()]);
            }

            $issue = $this->issue->create([
                'user_id' => $user_id,
                'title' => $title,
                'status' => 'new',
                'city_id' => $hood->city_id,
                'district_id' => $hood->district_id,
                'hood_id' => $hood->hood_id,
                'location' => $location,
                'is_anonymous' => 0,
                'coordinates' => $request->has('coordinates') ? $request->get('coordinates') : '',
                'supporter_count' => 0,
                'problem' => $request->get('problem'),
                'solution' => $request->get('solution')
            ]);

            $tags = $request->get('tags');

            if (!empty($tags) and is_array($tags)) {

                foreach ($tags as $tag) {

                    try {

                        DB::table('issue_tag')->insert([
                            'issue_id' => $issue->id,
                            'tag_id' => $tag,
                            'created_at' => Date::now(),
                            'updated_at' => Date::now(),
                        ]);
                        \Redis::incr('tag_issue_counter:' . $tag);

                    } catch (Exception $e) {

                        Log::error('IssuesController/postAdd/SavingTagRelation', (array)$e);
                        DB::rollBack();

                        return response()->api(401, 'Error on saving the issue', $request->all());
                    }
                }
            }

            $images = $request->get('images');

            #save the images
            if (!empty($images) and is_array($images)) {

                foreach ($images as $image) {

                    try {

                        $name = str_replace('.', '', microtime(true));
                        Storage::put('issues/' . $name, base64_decode($image));
                        DB::table('issue_images')->insert([
                            'issue_id' => $issue->id,
                            'image' => 'issues/' . $name,
                            'created_at' => Date::now(),
                            'updated_at' => Date::now(),
                        ]);

                    } catch (Exception $e) {

                        Log::error('IssuesController/postAdd/SavingTheImage', (array)$e);
                    }
                }
            }

            try {

                DB::table('issue_updates')->insert([
                    'user_id' => $user_id,
                    'issue_id' => $issue->id,
                    'old_status' => 'n/a',
                    'new_status' => 'new',
                    'created_at' => Date::now(),
                    'updated_at' => Date::now(),
                ]);

            } catch (Exception $e) {

                Log::error('IssuesController/postAdd/SavingIssueUpdate', (array)$e);
            }

            DB::commit();
            Redis::incr('user_opened_issue_counter:' . $user_id);

            $issue = $this->issue->with('user', 'tags', 'images')->find($issue->id);

            return response()->api(200, 'Issue saved', compact('issue'));

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->api(401, 'Exception occurred, please try again', []);
        }
    }

    private function checkDuplicate($user_id, $title, $location)
    {
        return $this->issue
            ->where('user_id', $user_id)
            ->where('title', $title)
            ->where('location', $location)
            ->count();
    }

}