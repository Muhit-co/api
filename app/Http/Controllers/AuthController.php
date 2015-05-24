<?php namespace Muhit\Http\Controllers;

use Auth;
use Authorizer;
use DB;
use Illuminate\Support\Str;
use Muhit\Http\Controllers\Controller;
use Muhit\Models\User;
use Request;

class AuthController extends Controller {

	/**
	 * register as a new user
	 *
	 * @return json
	 * @author
	 **/
	public function postRegister() {
		$data = Request::all();

		$required_fields = ['email', 'first_name', 'last_name', 'password', 'username', 'client_id', 'client_secret'];

		foreach ($required_fields as $key) {
			if (!isset($data[$key]) or empty($data[$key])) {
				return response()->api(400, 'Missing fields, ' . $key . ' is required', $data);
			}

		}

		$user = new User;

		$data['username'] = Str::slug($data['username']);

		$check_username = DB::table('users')->where('username', $data['username'])->first();
		$check_email = DB::table('users')->where('email', $data['email'])->first();

		if (null !== $check_email) {
			return response()->api(400, 'Duplicate entry on email.', $data);
		}

		if (null !== $check_username) {
			return response()->api(400, 'Duplicate entry on username', $data);
		}

		$user->username = $data['username'];
		$user->email = $data['email'];
		$user->password = bcrypt($data['password']);
		$user->first_name = $data['first_name'];
		$user->last_name = $data['last_name'];

		if (isset($data['active_hood']) and !empty($data['active_hood'])) {
			$user->active_hood = $data['active_hood'];
		}

		try {
			$user->save();
		} catch (Exception $e) {
			Log::error('AuthController/postRegister', (array) $e);
			return response()->api(500, 'Error while creating the user. ', ['details' => (array) $e]);
		}

		try {
			Auth::login($user);
			Request::merge(['grant_type' => 'direct', 'user_id' => $user->id]);
			$token = Authorizer::issueAccessToken();
		} catch (Exception $e) {
			Log::error('AuthController/postRegister', (array) $e);
			return response()->api(500, 'User saved but there were some errors on login.', ['details' => (array) $e]);
		}

		return response()->api(200, 'Registered and logged in. ', ['user' => $user, 'oauth2' => $token]);

	}

	/**
	 * login
	 *
	 * @return json
	 * @author
	 **/
	public function postLogin() {
		$data = Request::all();

		$required_fields = ['email', 'password', 'client_id', 'client_secret'];

		foreach ($required_fields as $key) {
			if (!isset($data[$key]) or empty($data[$key])) {
				return response()->api(400, 'Missing fields, ' . $key . ' is required', $data);
			}

		}

		if (!Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
			return response()->api(400, 'Wrong user credentials', $data);
		}

		Request::merge(['grant_type' => 'password', 'username' => $data['email']]);

		try {
			$token = Authorizer::issueAccessToken();
			$user = User::where('email', $data['email'])->firstOrFail();
		} catch (Exception $e) {
			Log::error('AuthController/postLogin', (array) $e);
			return response()->api(500, 'Cant login right now.', ['details' => (array) $e]);
		}

		return response()->api(200, 'Logged in. ', ['user' => $user, 'oauth2' => $token]);
	}

	/**
	 * login with facebook access token
	 *
	 * @return json
	 * @author
	 **/
	public function postLoginWithFacebook() {

	}

	/**
	 * starts the password forget routine.
	 *
	 * @return json
	 * @author
	 **/
	public function postSendPassword() {

	}

}
