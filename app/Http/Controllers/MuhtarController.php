<?php namespace Muhit\Http\Controllers;

use Auth;
use Carbon\Carbon;
use DB;
use Muhit\Http\Controllers\Controller;
use Muhit\Jobs\IssueCommented;
use Muhit\Jobs\IssueStatusUpdate;
use Muhit\Models\Comment;
use Muhit\Models\Issue;
use Request;

class MuhtarController extends Controller {

	private $avaliable_statuses = ['in-progress', 'solved'];

	/**
	 * comments to an issue
	 *
	 * @return redirect
	 * @author gcg
	 */
	public function postComment() {
		if (Request::has('issue_id') and Request::has('comment')) {

			$issue = Issue::find(Request::get('issue_id'));

			if (empty($issue)) {
				return redirect('/')
					->with('error', 'Issue deleted. ');
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
			$comment->issue_id = Request::get('issue_id');
			$comment->user_id = Auth::user()->id;
			$comment->comment = Request::get('comment');
			try {
				$comment->save();

				if (Request::has('issue_status')) {
					$new_status = Request::get('issue_status');

					if (in_array($new_status, $this->avaliable_statuses)) {
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
				Log::error('MuhtarController/postComment', (array) $e);
				return redirect('/issues/view/' . Request::get('issue_id'))
					->with('error', 'Yorumu kaydederken teknik bir hata meydana geldi, teknik ekip bilgilendirildi. ');
			}

			return redirect('/issues/view/' . Request::get('issue_id') . '#comment-' . $comment->id)
				->with('success', 'Yorum başarılı bir şekilde kaydedildi.');

		} else {
			return redirect('/')
				->with('error', 'Yorum yazmak için lütfen formu doldurun.');
		}

		return redirect('/');
	}

	/**
	 * deletes a comment
	 *
	 * @return redirect
	 * @author gcg
	 */
	public function getDeleteComment($id = null) {
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
			Log::error('MuhtarController/getDeleteComment', (array) $e);
			return redirect('/issues/view/' . $comment->issue_id)
				->with('error', 'Yorum silerken teknik bir hata meydana geldi. ');
		}

		return redirect('/issues/view/' . $comment->issue_id)
			->with('success', 'Yaptığınız yorumu sildiniz.');
	}

	/**
	 * edits a comment
	 *
	 * @return view
	 * @author gcg
	 */
	public function getEditComment($id = null) {
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
	public function postEditComment($id = null) {
		$comment = Comment::find($id);

		if (empty($comment)) {
			return redirect('/')
				->with('error', 'Düzenlemek istediğiniz yorum sistemde bulunmuyor...');
		}

		if ($comment->user_id != Auth::user()->id) {
			return redirect('/')
				->with('error', 'Sadece kendi yazdığınız yorumları düzenleyebilirsiniz.');
		}

		if (Request::has('comment')) {
			$comment->comment = Request::get('comment');
			try {
				$comment->save();

			} catch (Exception $e) {
				Log::error('MuhtarController/postEditComment', (array) $e);
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
