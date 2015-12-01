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

	}

	/**
	 * displays a form for editing a member
	 *
	 * @return view
	 * @author gcg
	 */
	public function getEditMember($id = null) {

	}

	/**
	 * rejects a pending muhtar
	 *
	 * @return redirect
	 * @author gcg
	 */
	public function getRejectMuhtar($id = null) {

	}

	/**
	 * approves a muhtar
	 *
	 * @return redirect
	 * @author gcg
	 */
	public function getApproveMuhtar($id = null) {

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

	}

}
