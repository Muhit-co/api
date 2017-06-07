<?php namespace Muhit\Http\Controllers;

use Auth;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Http\Request;
use Log;
use Muhit\Jobs\IssueCommented;
use Muhit\Jobs\IssueStatusUpdate;
use Muhit\Models\Comment;
use Muhit\Models\Issue;
use Muhit\Repositories\Muhtar\MuhtarRepositoryInterface;
use Slack;

class CommentsController extends Controller
{



    /**
     * comments to an issue
     *
     * @param Request $request
     * @return redirect
     * @author gcg
     */
    public function postComment(Request $request)
    {
        if ($request->has('issue_id') && $request->has('comment')) {
            $issue = Issue::find($request->get('issue_id'));

            if (!$issue) {
                return redirect('/')->with('error', 'Issue deleted. ');
            }
            $comment = new Comment;
            $comment->issue_id = $request->get('issue_id');
            $comment->user_id = Auth::user()->id;
            $comment->comment = $request->get('comment');
            try {
                $comment->save();

                $this->dispatch(new IssueCommented($comment->id));

                // Send a message to Slack webhoook
                $comment->issue_title = $issue->title;
                $comment->user_name = Auth::user()->first_name . ' ' . Auth::user()->last_name;
                Slack::attach(getSlackCommentAttachment($comment))->withIcon(':speech_balloon:')->send('New comment (' . $comment->id . ') on muhit.co');
            } catch (Exception $e) {
                Log::error('CommentsController/postComment', (array)$e);

                return redirect('/issues/view/' . $request->get('issue_id'))
                    ->with('error', 'Yorumu kaydederken teknik bir hata meydana geldi, teknik ekip bilgilendirildi. ');
            }


            return redirect('/issues/view/' . $request->get('issue_id') . '#comment-' . $comment->id)
                ->with('success', 'Yorum başarılı bir şekilde kaydedildi.');
        } else {
            return redirect('/')
                ->with('error', 'Yorum yazmak için lütfen formu doldurun.');
        }
    }
}
