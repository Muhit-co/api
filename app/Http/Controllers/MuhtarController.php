<?php namespace Muhit\Http\Controllers;

use Muhit\Http\Controllers\Controller;
use Muhit\Models\Comment;
use Request;

class MuhtarController extends Controller {

	/**
	 * comments to an issue
	 *
	 * @return redirect
	 * @author gcg
	 */
	public function postComment() {
		if (Request::has('issue_id') and Request::has('comment')) {
			$comment = new Comment;
			$comment->issue_id = Request::get('issue_id');
			$comment->user_id = Auth::user()->id;
			$comment->comment = Request::get('comment');
			try {
				$comment->save();

				#queueu an email for 10 minutes to issues owner.
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
