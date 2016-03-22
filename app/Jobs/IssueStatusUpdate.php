<?php

namespace Muhit\Jobs;

use DB;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;
use Muhit\Jobs\Job;
use Muhit\Jobs\SendStatusUpdateEmail;
use Muhit\Models\Comment;

class IssueStatusUpdate extends Job implements SelfHandling, ShouldQueue {
	use InteractsWithQueue;
	use DispatchesJobs;

	protected $comment_id;
	protected $status;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct($comment_id, $status) {
		$this->comment_id = $comment_id;
		$this->status = $status;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle() {

		$comment = Comment::with('muhtar', 'issue')->find($this->comment_id);

		if (!empty($comment->issue->user_id)) {
			try {
				$this->dispatch(new SendStatusUpdateEmail($comment->issue->user_id, 'owner', $comment->id, $this->status));
			} catch (Exception $e) {
				Log::error('IssueStatusUpdate', (array) $e);
			}
		}

		#find the supporters of the issue
		$supporters = DB::table('issue_supporters')
			->where('issue_id', $comment->issue_id)
			->where('user_id', '<>', $comment->issue->user_id)
			->get();

		foreach ($supporters as $s) {
			try {
				$this->dispatch(new SendStatusUpdateEmail($s->user_id, 'supporter', $comment->id, $this->status));
			} catch (Exception $e) {
				Log::error('IssueStatusUpdate', (array) $e);
			}
		}

	}
}
