<?php

namespace Muhit\Jobs;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;
use Muhit\Jobs\Job;
use Muhit\Models\Issue;
use Muhit\Models\User;

class SendIssueSupportedEmail extends Job implements SelfHandling, ShouldQueue {
	use InteractsWithQueue;

	protected $user_id;
	protected $issue_id;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct($user_id, $issue_id) {
		$this->user_id = $user_id;
		$this->issue_id = $issue_id;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle() {

		$user = User::find($this->user_id);
		$issue = Issue::with('user')->find($this->issue_id);

		if (!empty($issue->user) and $issue->user->is_verified == 1) {

			try {
				$email = 'created_idea_supported';

				Mail::send('emails.' . $email, ['user' => $user, 'issue' => $issue], function ($m) use ($user, $email, $issue) {
					$m->to($issue->user->email)
						->subject(trans('email.' . $email . '_title'));
				});
			} catch (Exception $e) {
				Log::error('SendIssueSupportedEmail', (array) $e);
			}
		}

	}
}
