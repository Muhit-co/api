<?php

namespace Muhit\Jobs;

use DB;
use Exception;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;
use Muhit\Jobs\SendCommentedEmail;
use Log;
use Muhit\Models\Comment;
use Carbon\Carbon;

class IssueCommented extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue;
    use DispatchesJobs;

    protected $comment_id;

    /**
     * Create a new job instance.
     * @param $comment_id
     */
    public function __construct($comment_id)
    {
        $this->comment_id = $comment_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $comment = Comment::with('muhtar', 'issue')->find($this->comment_id);

        Log::error(Carbon::now().' IssueCommented new job', (array) $comment);

        if (!empty($comment->issue->user_id)) {
            try {
                $this->dispatch(new SendCommentedEmail($comment->issue->user_id, 'owner', $comment->id, $comment->muhtar->id));
            } catch (Exception $e) {
                Log::error('IssueCommented', (array)$e);
            }
        }

        #find the supporters of the issue
        $supporters = DB::table('issue_supporters')
            ->where('issue_id', $comment->issue_id)
            ->where('user_id', '<>', $comment->issue->user_id)
            ->get();

        foreach ($supporters as $s) {
            try {
                $this->dispatch(new SendCommentedEmail($s->user_id, 'supporter', $comment->id, $comment->muhtar->id));
            } catch (Exception $e) {
                Log::error('IssueCommented', (array)$e);
            }
        }
    }
}
