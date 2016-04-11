<?php

namespace Muhit\Jobs;

use Exception;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Log;
use Mail;
use Muhit\Models\Comment;
use Muhit\Models\User;

class SendStatusUpdateEmail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue;

    protected $user_id;
    protected $target;
    protected $comment_id;
    protected $status;

    /**
     * Create a new job instance.
     *
     * @param $user_id
     * @param $target
     * @param $comment_id
     * @param $status
     */
    public function __construct($user_id, $target, $comment_id, $status)
    {
        $this->user_id = $user_id;
        $this->target = $target;
        $this->comment_id = $comment_id;
        $this->status = $status;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $user = User::find($this->user_id);
        $comment = Comment::with('issue', 'muhtar')->find($this->comment_id);

        if (!empty($user) and $user->is_verified == 1) {

            $email = '';

            try {
                if ($this->target === 'owner') {

                    $email .= 'created_';

                } else {

                    $email .= 'supported_';
                }

                $email .= 'idea_';

                if ($this->status === 'solved') {

                    $email .= 'solved';

                } else {

                    $email .= 'into_development';
                }

                Mail::send('emails.' . $email, ['user' => $user, 'comment' => $comment],
                    function ($m) use ($user, $email) {
                        $m->to($user->email)
                            ->subject(trans('email.' . $email . '_title'));
                    });

            } catch (Exception $e) {

                Log::error('SendStatusUpdateEmail', (array)$e);
            }
        }

    }
}
