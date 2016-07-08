<?php

namespace Muhit\Repositories\Issue;

use Date;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Log;
use Muhit\Jobs\IssueRemoved;
use Muhit\Jobs\SendIssueSupportedEmail;
use Muhit\Models\Hood;
use Muhit\Models\Issue;
use Muhit\Models\IssueSupporter;
use Muhit\Models\User;
use Redis;
use ResponseService;
use Storage;

class IssueRepository implements IssueRepositoryInterface
{
    protected $issue;
    protected $hood;
    private $user;
    private $issueSupporter;

    public function __construct(Issue $issue, Hood $hood, User $user, IssueSupporter $issueSupporter)
    {
        $this->issue = $issue;
        $this->hood = $hood;
        $this->user = $user;
        $this->issueSupporter = $issueSupporter;
    }

    public function all(Request $request, $start, $end)
    {
        $issues = $this->issue->with('user', 'tags', 'images')
            ->orderBy('id', 'desc')
            ->skip($start)
            ->take($end)
            ->get();

        return ResponseService::createResponse('issues', $issues);
    }

    public function supporters($issue_id)
    {
        $issue = $this->issue->find($issue_id);

        if (!$issue) {

            return ResponseService::createErrorMessage('issueNotFound');
        }

        $supporters = $this->issueSupporter->where('issue_id', $issue_id)
            ->join('users', 'users.id', '=', 'issue_supporters.user_id')
            ->orderBy('issue_supporters.created_at', 'desc')
            ->get([
                'users.id',
                'first_name',
                'email',
                'password',
                'last_name',
                'picture',
                'username',
            ]);

        return ResponseService::createResponse('supporters', $supporters);
    }

    public function get(Request $request, $id)
    {
        $issue = $this->issue->with('user', 'tags', 'images', 'comments.muhtar')->find($id);

        if (!$issue) {

            return ResponseService::createErrorMessage('issueNotFound');
        }

        return ResponseService::createResponse('issue', $issue);
    }

    public function create(Request $request)
    {
        $user_id = $request->get('user_id');
        $title = $request->get('title');
        $location = $request->get('location');

        if ($this->checkDuplicate($user_id, $title, $location) > 0) {

            return ResponseService::createErrorMessage('issueExists');
        }

        try {

            DB::beginTransaction();

            $location_parts = explode(",", $location);
            $hood = false;

            if (count($location_parts) === 3) {

                $hood = Hood::fromLocation($location);
            }

            if (!$hood || !isset($hood->id) or !isset($hood->city_id) or !isset($hood->district_id)) {

                DB::rollBack();

                return ResponseService::createErrorMessage('cantGetHoodInfo');
            }

            $issue = $this->issue->create([
                'user_id' => $user_id,
                'title' => $title,
                'status' => 'new',
                'city_id' => $hood->city_id,
                'district_id' => $hood->district_id,
                'hood_id' => $hood->id,
                'location' => $location,
                'is_anonymous' => 0,
                'coordinates' => $request->has('coordinates') ? $request->get('coordinates') : '',
                'supporter_count' => 0,
                'problem' => $request->get('problem'),
                'solution' => $request->get('solution')
            ]);

            $tags = $request->get('tags');

            if (Str::length($tags) > 1) {

                $tagList = explode(',', $tags);

                foreach ($tagList as $tag) {

                    try {

                        DB::table('issue_tag')->insert([
                            'issue_id' => $issue->id,
                            'tag_id' => $tag,
                            'created_at' => Date::now(),
                            'updated_at' => Date::now(),
                        ]);

                        Redis::incr('tag_issue_counter:' . $tag);

                    } catch (Exception $e) {

                        Log::error('IssuesController/postAdd/SavingTagRelation', (array)$e);
                        DB::rollBack();

                        return ResponseService::createErrorMessage('errorOccurredWhileSaving');
                    }
                }
            }

            $images = $request->get('images');

            if (Str::length($images) > 1) {

                $imageList = explode(',', $images);

                foreach ($imageList as $image) {

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

            return ResponseService::createResponse('issue', $issue);

        } catch (\Exception $e) {

            DB::rollBack();

            return ResponseService::createErrorMessage('exceptionOccurred');
        }
    }

    public function update($user_id, $issue_id, Request $request)
    {
        
    }
    
    private function checkDuplicate($user_id, $title, $location)
    {
        return $this->issue
            ->where('user_id', $user_id)
            ->where('title', $title)
            ->where('location', $location)
            ->count();
    }

    public function delete($user_id, $issue_id)
    {
        $user = $this->user->find($user_id);

        if (!$user) {

            return ResponseService::createErrorMessage('userNotFound');
        }

        $issue = $this->issue->find($issue_id);

        if (!$issue) {

            return ResponseService::createErrorMessage('issueNotFound');
        }

        $can_delete = false;

        if ($user_id == $issue->user_id) {

            $can_delete = true;

        } else {

            $user_level = $this->user->where('id', $user_id)->pluck('level');

            if ($user_level > 5) {

                $can_delete = true;
            }
        }

        if (!$can_delete || $issue->status != 'new' || (int)Redis::get('supporter_counter:' . $issue->id) > 10) {

            return ResponseService::createErrorMessage('authorizationError');
        }

        try {

            $issue->delete();

            DB::table('issue_updates')
                ->insert([
                    'user_id' => $user_id,
                    'issue_id' => $issue_id,
                    'old_status' => $issue->status,
                    'new_status' => 'deleted',
                    'created_at' => Date::now(),
                    'updated_at' => Date::now(),
                ]);

            \Queue::push(new IssueRemoved($issue_id));

        } catch (Exception $e) {
            Log::error('IssuesController/getDelete', (array)$e);

            return ResponseService::createErrorMessage('exceptionOccurred');
        }

        return ResponseService::createSuccessMessage('issueDeleted');
    }

    public function supported($user_id)
    {
        $issues = $this->issue
            ->with('user', 'tags', 'images')
            ->whereHas('supporters', function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            })
            ->get();

        return ResponseService::createResponse('issues', $issues);
    }

    public function created($user_id)
    {
        $issues = $this->issue->with('user', 'tags', 'images')
            ->where('user_id', $user_id)
            ->orderBy('id', 'desc')
            ->get();

        return ResponseService::createResponse('issues', $issues);
    }

    public function support($issue_id, $user_id)
    {
        $user = $this->user->find($user_id);

        if (!$user) {

            return ResponseService::createErrorMessage('userNotFound');
        }

        $issue = $this->issue->find($issue_id);

        if (!$issue) {

            return ResponseService::createErrorMessage('issueNotFound');
        }

        $doesSupportExists = $this->issueSupporter
            ->where('user_id', $user_id)
            ->where('issue_id', $issue_id)
            ->count();

        if ($doesSupportExists > 0) {

            return ResponseService::createErrorMessage('issueAlreadySupported');
        }

        try {

            $this->issueSupporter->create([
                'issue_id' => $issue_id,
                'user_id' => $user_id
            ]);

            Redis::incr('user_supported_issue_counter:' . $user_id);
            DB::table('issues')->where('id', $issue_id)->increment('supporter_count');
            $su_counter = (int)Redis::incr('supporter_counter:' . $issue_id);
            Redis::zadd('issue_supporters:' . $issue_id, time(), $user_id);

            \Queue::push(new SendIssueSupportedEmail($user_id, $issue_id));

        } catch (Exception $e) {

            Log::error('IssuesController/getSupport', (array)$e);

            return ResponseService::createErrorMessage('facebookPostError');
        }

        return ResponseService::createSuccessMessage('issueSupported');
    }

    public function unsupport($issue_id, $user_id)
    {
        $user = $this->user->find($user_id);

        if (!$user) {

            return ResponseService::createErrorMessage('userNotFound');
        }

        $issue = $this->issue->find($issue_id);

        if (!$issue) {

            return ResponseService::createErrorMessage('issueNotFound');
        }

        $doesSupportExists = $this->issueSupporter
            ->where('user_id', $user_id)
            ->where('issue_id', $issue_id)
            ->count();

        if ($doesSupportExists > 0) {

            return ResponseService::createErrorMessage('issueAlreadySupported');
        }

        $doesSupportExists = $this->issueSupporter
            ->where('user_id', $user_id)
            ->where('issue_id', $issue_id)
            ->first();

        if (!$doesSupportExists) {

            return ResponseService::createErrorMessage('supportNotExist');
        }

        try {

            $doesSupportExists->delete();
            Redis::decr('user_supported_issue_counter:' . $user_id);
            $su_counter = (int) Redis::decr('supporter_counter:' . $issue_id);
            Redis::zrem('issue_supporters:' . $issue_id, $user_id);

        } catch (Exception $e) {

            Log::error('IssuesController/getUnSupport', (array) $e);

            return ResponseService::createErrorMessage('facebookPostError');
        }

        return ResponseService::createSuccessMessage('issueUnsupported');
    }

}