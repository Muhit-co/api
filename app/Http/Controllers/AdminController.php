<?php namespace Muhit\Http\Controllers;

use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Str;
use Muhit\Http\Controllers\Controller;
use Muhit\Models\Hood;
use Muhit\Models\User;
use Request;
use Storage;

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

		$filterable_fields = ['level', 'location', 'q'];

		foreach ($filterable_fields as $f) {
			if (Request::has($f)) {
				if ($f == 'q') {
					$users->where('username', 'LIKE', '%' . Request::get($f) . '%')
						->orWhere('first_name', 'LIKE', '%' . Request::get($f) . '%')
						->orWhere('last_name', 'LIKE', '%' . Request::get($f) . '%')
						->orWhere('email', 'LIKE', '%' . Request::get($f) . '%');
				} else {
					$users->where($f, 'LIKE', '%' . Request::get($f) . '%');
				}

			}
		}

		return response()->app(200, 'admin.members.index', ['members' => $users->paginate(30), 'filters' => Request::all()]);

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

		return response()->app(200, 'admin.members.show', ['member' => $member, 'updates' => $updates]);
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

		return response()->app(200, 'admin.members.edit', ['member' => $member]);
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
		$data = Request::all();

		$user = User::find($data['id']);

		if (empty($user)) {
			return redirect('/admin/members')
				->with('error', 'Kullanıcı bulanamdı.');
		}

		if (isset($data['email']) and filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
			$user->email = $data['email'];
			$user->is_verified = 0;
		}

		#lets figure out the location.
		$location_parts = explode(",", $data['location']);
		$hood = false;
		if (count($location_parts) === 3) {
			$hood = Hood::fromLocation($data['location']);
		}

		if (isset($hood) and isset($hood->id)) {
			$user->hood_id = $hood->id;
		}

		if (isset($data['username']) and !empty($data['username'])) {
			$data['username'] = Str::slug($data['username']);
			$check_slug = (int) DB::table('users')
				->where('username', $data['username'])
				->where('id', '<>', $data['id'])
				->count();
			if ($check_slug === 0) {
				$user->username = $data['username'];
			}
		}

		if (isset($data['first_name']) and !empty($data['first_name'])) {
			$user->first_name = $data['first_name'];
		}
		if (isset($data['last_name']) and !empty($data['last_name'])) {
			$user->last_name = $data['last_name'];
		}
		if (isset($data['location']) and !empty($data['location'])) {
			$user->location = $data['location'];

		}

		if (!empty($data['image']) and is_array($data['image'])) {
			try {
				$name = str_replace('.', '', microtime(true));
				Storage::put('users/' . $name, base64_decode($data['image']));
				$user->picture = $name;
			} catch (Exception $e) {
				Log::error('AdminController/postSaveMember/SavingTheImage', (array) $e);
			}
		}

		try {
			$user->save();
		} catch (Exception $e) {
			Log::error('AdminController/postSaveMember', (array) $e);

			return redirect('/admin/edit-member/' . $data['id'])
				->with('error', 'Profili güncellerken bir hata meydana geldi.');
		}

		return redirect('/admin/view-member/' . $data['id'])
			->with('success', 'Profiliniz güncellendi.');

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
