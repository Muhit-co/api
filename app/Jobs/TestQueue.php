<?php

namespace Muhit\Jobs;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;
use Muhit\Jobs\Job;

class TestQueue extends Job implements SelfHandling, ShouldQueue {
	use InteractsWithQueue, SerializesModels;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct() {
		//
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle() {
		Mail::send('emails.forgot_password', ['string' => 'test', 'email' => 'test'], function ($m) {
			$m->to('guneycan@gmail.com')
				->subject('Muhit.co Test Queue Email');
		});
	}
}
