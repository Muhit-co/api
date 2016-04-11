<?php

namespace Muhit\Jobs;

use Exception;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Log;
use Mail;
use Muhit\Models\User;

class SignupConfirmation extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue;

    protected $user_id;

    /**
     * Create a new job instance.
     *
     * @param $user_id
     */
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $user = User::find($this->user_id);

        if (!empty($user) and $user->is_verified == 0) {

            $user->verify_token = bin2hex(mcrypt_create_iv(17, MCRYPT_DEV_URANDOM));

            try {

                $user->save();

                Mail::send('emails.sign_up_conf', ['user' => $user], function ($m) use ($user) {
                    $m->to($user->email)
                        ->subject('Muhit.co Hesap onay epostası.');
                });

            } catch (Exception $e) {

                Log::error('SignupConfirmation', (array)$e);
            }
        }

    }
}
