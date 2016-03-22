<?php

namespace Muhit\Jobs;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;
use Muhit\Jobs\Job;
use Muhit\Models\Issue;
use Muhit\Models\User;

class SendRemovedEmail extends Job implements SelfHandling, ShouldQueue {
	use InteractsWithQueue;

	protected $user_id;
	protected $target;
	protected $issue_id;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct($user_id, $target, $issue_id) {
		$this->user_id = $user_id;
		$this->target = $target;
		$this->issue_id = $issue_id;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle() {

		$user = User::find($this->user_id);
		$issue = Issue::withTrashed()->find($this->issue_id);

		if (!empty($user) and $user->is_verified == 1) {

			try {
				if ($this->target === 'owner') {
					$email = 'created_idea_removed';
				} else {
					$email = 'supported_idea_removed';
				}

				Mail::send('emails.' . $email, ['user' => $user, 'issue' => $issue], function ($m) use ($user, $email) {
					$m->to($user->email)
						->subject(trans('email.' . $email . '_title'));
				});
			} catch (Exception $e) {
				Log::error('SendRemovedEmail', (array) $e);
			}
		}

	}
}
