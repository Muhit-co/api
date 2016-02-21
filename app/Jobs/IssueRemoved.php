<?php

namespace Muhit\Jobs;

use DB;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;
use Muhit\Jobs\Job;
use Muhit\Jobs\SendRemovedEmail;
use Muhit\Models\Issue;

class IssueRemoved extends Job implements SelfHandling, ShouldQueue {
	use InteractsWithQueue;
	use DispatchesJobs;

	protected $issue_id;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct($issue_id) {
		$this->issue_id = $issue_id;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle() {

		$issue = Issue::withTrashed()->with('user')->find($this->issue_id);

		if (!empty($issue->user_id)) {
			try {
				$this->dispatch(new SendRemovedEmail($issue->user_id, 'owner', $issue->id));
			} catch (Exception $e) {
				Log::error('IssueRemoved', (array) $e);
			}
		}

		#find the supporters of the issue
		$supporters = DB::table('issue_supporters')
			->where('issue_id', $issue->id)
			->where('user_id', '<>', $issue->user_id)
			->get();

		foreach ($supporters as $s) {
			try {
				$this->dispatch(new SendRemovedEmail($s->user_id, 'supporter', $issue->id));
			} catch (Exception $e) {
				Log::error('IssueRemoved', (array) $e);
			}
		}

	}
}
