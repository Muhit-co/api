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

class MuhtarController extends Controller
{

    private $muhtar;

    public function __construct(MuhtarRepositoryInterface $muhtar)
    {
        parent::__construct();
        $this->muhtar = $muhtar;
    }

    public function index()
    {
        $muhtar = $this->muhtar->getMuhtar();

        return view('pages.muhtar', compact('muhtar'));
    }

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

            $can_comment = false;

            if (!empty($issue->location) and !empty(Auth::user()->location) and $issue->location == Auth::user()->location) {

                $can_comment = true;
            }

            if (!$can_comment) {

                return redirect('/issues/view/' . $issue->id)
                    ->with('error', 'Sadece kendi bölgenizdeki fikirlere yorum yapabilirisniz.');
            }

            $comment = new Comment;
            $comment->issue_id = $request->get('issue_id');
            $comment->user_id = Auth::user()->id;
            $comment->comment = $request->get('comment');
            try {
                $comment->save();

                if ($request->has('issue_status')) {

                    $new_status = $request->get('issue_status');

                    if (in_array($new_status, ['in-progress', 'solved'])) {

                        $old_status = $issue->status;
                        $issue->status = $new_status;
                        $issue->save();

                        DB::table('issue_updates')
                            ->insert([
                                'user_id' => Auth::user()->id,
                                'issue_id' => $issue->id,
                                'old_status' => $old_status,
                                'new_status' => $new_status,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ]);

                        $this->dispatch(new IssueStatusUpdate($comment->id, $new_status));
                    }

                } else {

                    $this->dispatch(new IssueCommented($comment->id));
                }

            } catch (Exception $e) {
                Log::error('MuhtarController/postComment', (array)$e);

                return redirect('/issues/view/' . $request->get('issue_id'))
                    ->with('error', 'Yorumu kaydederken teknik bir hata meydana geldi, teknik ekip bilgilendirildi. ');
            }

            // Send a message to Slack webhoook
            $comment->issue_title = $issue->title;
            $comment->user_name = Auth::user()->first_name . ' ' . Auth::user()->last_name;
            Slack::attach( getSlackCommentAttachment($comment) )->withIcon(':speech_balloon:')->send('New comment (' . $comment->id . ') on muhit.co');

            return redirect('/issues/view/' . $request->get('issue_id') . '#comment-' . $comment->id)
                ->with('success', 'Yorum başarılı bir şekilde kaydedildi.');

        } else {

            return redirect('/')
                ->with('error', 'Yorum yazmak için lütfen formu doldurun.');
        }
    }

    /**
     * deletes a comment
     *
     * @param null $id
     * @return redirect
     * @author gcg
     */
    public function getDeleteComment($id = null)
    {
        $comment = Comment::find($id);

        if (empty($comment)) {
            return redirect('/')
                ->with('error', 'Silmek istediğiniz yorum sistemde bulunmuyor...');
        }

        if ($comment->user_id != Auth::user()->id) {
            return redirect('/')
                ->with('error', 'Sadece kendi yazdığınız yorumları silebilirsiniz...');
        }

        try {

            $comment->delete();

        } catch (Exception $e) {

            Log::error('MuhtarController/getDeleteComment', (array)$e);

            return redirect('/issues/view/' . $comment->issue_id)
                ->with('error', 'Yorum silerken teknik bir hata meydana geldi. ');
        }

        return redirect('/issues/view/' . $comment->issue_id)
            ->with('success', 'Yaptığınız yorumu sildiniz.');
    }

    /**
     * edits a comment
     *
     * @param null $id
     * @return view
     * @author gcg
     */
    public function getEditComment($id = null)
    {
        $comment = Comment::find($id);

        if (empty($comment)) {
            return redirect('/')
                ->with('error', 'Düzenlemek istediğiniz yorum sistemde bulunmuyor...');
        }

        if ($comment->user_id != Auth::user()->id) {
            return redirect('/')
                ->with('error', 'Sadece kendi yazdığınız yorumları düzenleyebilirsiniz.');
        }

        return response()->app(200, 'comments.edit', ['comment' => $comment]);
    }

    /**
     * saves an editted comment
     *
     * @return view
     * @author gcg
     */
    public function postEditComment($id = null, Request $request)
    {
        $comment = Comment::find($id);

        if (empty($comment)) {

            return redirect('/')
                ->with('error', 'Düzenlemek istediğiniz yorum sistemde bulunmuyor...');
        }

        if ($comment->user_id != Auth::user()->id) {

            return redirect('/')
                ->with('error', 'Sadece kendi yazdığınız yorumları düzenleyebilirsiniz.');
        }

        if ($request->has('comment')) {

            $comment->comment = $request->get('comment');

            try {

                $comment->save();

            } catch (Exception $e) {
                Log::error('MuhtarController/postEditComment', (array)$e);

                return redirect('/issues/view/' . $comment->issue_id)
                    ->with('error', 'Yorumunuzu düzenlerken teknik bir hata meydana geldi.');
            }

            return redirect('/issues/view/' . $comment->issue_id . '#comment-' . $comment->id)
                ->with('success', 'Yorumunuz başarılı bir şekilde güncellendi');

        } else {

            return redirect('/issues/view/' . $comment->issue_id)
                ->with('error', 'Lütfen yorumunuzu yazıp tekrar deneyin.');
        }
    }
}
