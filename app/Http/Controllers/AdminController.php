<?php namespace Muhit\Http\Controllers;

use Muhit\Http\Controllers\Controller;
use Muhit\Models\User;
use Request;

class AdminController extends Controller {

	/**
	 * list users based on filters and pagination
	 *
	 * @return view
	 * @author gcg
	 */
	public function getMembers() {

		$order = ((Request::has('order')) ? Request::get('order') : 'id');
		$dir = ((Request::has('dir')) ? Request::get('dir') : 'asc');

		$users = User::orderBy($order, $dir);

		$filterable_fields = ['username', 'level', 'email', 'first_name', 'last_name', 'location'];

		foreach ($filterable_fields as $f) {
			if (Request::has($f)) {
				$users->where($f, 'LIKE', '%' . Request::get($f) . '%');
			}
		}

		return response()->app(200, 'members.index', ['members' => $users->paginate(30), 'filters' => Request::all()]);

	}

	/**
	 * displays the information about a muhtar
	 *
	 * @return view
	 * @author gcg
	 */
	public function getViewMember($id = null) {
		$member = User::find($id);

		if (empty($member)) {
			return redirect('/admin/members')
				->with('error', 'Aradığınız kullanıcı bulunamıyor. ');
		}

		$updates = DB::table('user_updates')->where('user_id', $member->id)->get();

		return response()->app(200, 'members.view', ['member' => $member, 'updates' => $updates]);
	}

	/**
	 * displays a form for editing a member
	 *
	 * @return view
	 * @author gcg
	 */
	public function getEditMember($id = null) {
		$member = User::find($id);

		if (empty($member)) {
			return redirect('/admin/members')
				->with('error', 'Aradığınız kullanıcı bulunamıyor. ');
		}

		return response()->app(200, 'members.edit', ['member' => $member]);
	}

	/**
	 * rejects a pending muhtar
	 *
	 * @return redirect
	 * @author gcg
	 */
	public function getRejectMuhtar($id = null) {
		$member = User::find($id);

		if (empty($member)) {
			return redirect('/admin/members')
				->with('error', 'Aradığınız kullanıcı bulunamıyor. ');
		}

		if ($member->level != 4) {
			return redirect('/admin/members')
				->with('error', 'Muhtar onay beklemiyor, onay beklemeyen muhtarları reject edemezsin.');
		}

		$tmp = [
			'created_at' => Carbon::now(),
			'updated_at' => Carbon::now(),
			'source_id' => Auth::user()->id,
			'previous_level' => $member->level,
			'current_level' => 3,
			'user_id' => $member->id,
		];

		try {
			$member->level = 3;
			$member->save();
			DB::table('user_updates')->insert($tmp);
		} catch (Exception $e) {
			Log::error('AdminController/getRejectMuhtar', (array) $e);
			return redirect('/admin/members')
				->with('error', 'Muhtar güncellenirken bir hata oldu.');
		}

		return redirect('/admin/view-member/' . $member->id)
			->with('success', 'Muhtar reject edildi.');
	}

	/**
	 * approves a muhtar
	 *
	 * @return redirect
	 * @author gcg
	 */
	public function getApproveMuhtar($id = null) {
		$member = User::find($id);

		if (empty($member)) {
			return redirect('/admin/members')
				->with('error', 'Aradığınız kullanıcı bulunamıyor. ');
		}

		if ($member->level != 4) {
			return redirect('/admin/members')
				->with('error', 'Muhtar onay beklemiyor, onay beklemeyen muhtarları approve edemezsin.');
		}

		$tmp = [
			'created_at' => Carbon::now(),
			'updated_at' => Carbon::now(),
			'source_id' => Auth::user()->id,
			'previous_level' => $member->level,
			'current_level' => 5,
			'user_id' => $member->id,
		];

		try {
			$member->level = 5;
			$member->save();
			DB::table('user_updates')->insert($tmp);
		} catch (Exception $e) {
			Log::error('AdminController/getApproveMuhtar', (array) $e);
			return redirect('/admin/members')
				->with('error', 'Muhtar güncellenirken bir hata oldu.');
		}

		return redirect('/admin/view-member/' . $member->id)
			->with('success', 'Muhtar onaylandı.');
	}

	/**
	 * saves a member information
	 *
	 * @return redirect
	 * @author gcg
	 */
	public function postSaveMember() {

	}

	/**
	 * deletes a member from the database
	 *
	 * @return redirect
	 * @author gcg
	 */
	public function getDeleteMember($id = null) {
		$member = User::find($id);

		if (empty($member)) {
			return redirect('/admin/members')
				->with('error', 'Aradığınız kullanıcı bulunamıyor. ');
		}

		$tmp = [
			'created_at' => Carbon::now(),
			'updated_at' => Carbon::now(),
			'source_id' => Auth::user()->id,
			'previous_level' => $member->level,
			'current_level' => 0,
			'user_id' => $member->id,
		];

		try {
			$member->delete();
			DB::table('user_updates')->insert($tmp);
		} catch (Exception $e) {
			Log::error('AdminController/getDeleteMember', (array) $e);
			return redirect('/admin/members')
				->with('error', 'Üye silinirken bir hata oluştu.');
		}

		return redirect('/admin/members')
			->with('success', 'Üye silindi.');

	}

}
