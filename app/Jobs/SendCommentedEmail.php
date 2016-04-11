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

class SendCommentedEmail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue;

    protected $user_id;
    protected $target;
    protected $comment_id;

    /**
     * Create a new job instance.
     *
     * @param $user_id
     * @param $target
     * @param $comment_id
     */
    public function __construct($user_id, $target, $comment_id)
    {
        $this->user_id = $user_id;
        $this->target = $target;
        $this->comment_id = $comment_id;
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

            try {

                if ($this->target === 'owner') {

                    $email = 'created_idea_commented';

                } else {

                    $email = 'supported_idea_commented';
                }

                Mail::send('emails.' . $email, ['user' => $user, 'comment' => $comment],
                    function ($m) use ($user, $email) {
                        $m->to($user->email)
                            ->subject(trans('email.' . $email . '_title'));
                    });

            } catch (Exception $e) {

                Log::error('SendCommentedEmail', (array)$e);
            }
        }

    }
}
