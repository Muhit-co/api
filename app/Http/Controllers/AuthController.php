<?php namespace Muhit\Http\Controllers;

use Auth;
use Authorizer;
use Config;
use DB;
use Facebook\FacebookRequest;
use Facebook\FacebookSession;
use Facebook\GraphUser;
use Illuminate\Support\Str;
use Muhit\Http\Controllers\Controller;
use Muhit\Models\User;
use Muhit\Models\UserSocialAccount;
use Request;
use Log;

class AuthController extends Controller {

	/**
	 * register as a new user
	 *
	 * @return json
	 * @author
	 **/
	public function postRegister() {
		$data = Request::all();

        Log::error('Auth/Register/fired', []);

		$required_fields = ['email', 'first_name', 'last_name', 'password', 'client_id', 'client_secret'];

		foreach ($required_fields as $key) {
			if (!isset($data[$key]) or empty($data[$key])) {
				return response()->api(400, 'Missing fields, ' . $key . ' is required', $data);
			}

		}

        $user = new User;

        if (!isset($data['username'])) {
            $data['username'] = '';
        }

        $data['username'] = Str::slug($data['username']);
        if (empty($data['username'])) {
            $data['username'] = Str::slug($data['first_name'])."-".Str::slug($data['last_name']);
        }

		$check_username = DB::table('users')->where('username', $data['username'])->first();
		$check_email = DB::table('users')->where('email', $data['email'])->first();

        if (null !== $check_email) {
            Log::error('Auth/Register/DuplicateEmail', $data);
			return response()->api(400, 'Duplicate entry on email.', $data);
		}

		if (null !== $check_username) {
            $data['username'] = $data['username'].time();
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
		$data = Request::all();
		$required_fields = ['access_token', 'client_id', 'client_secret'];

		foreach ($required_fields as $key) {
			if (!isset($data[$key]) or empty($data[$key])) {
				return response()->api(400, 'Missing fields, ' . $key . ' is required', $data);
			}

		}

		FacebookSession::setDefaultApplication(Config::get('services.facebook.client_id'), Config::get('services.facebook.client_secret'));

		try {
			$session = new FacebookSession($data['access_token']);
		} catch (Exception $e) {
			Log::error('AuthController/postLoginWithFacebook', (array) $e);
			return response()->api(400, 'Wrong access token', $data);
		}

		if (isset($session) and $session) {
			try {
				$me = (new FacebookRequest(
					$session, 'GET', '/me'
				))->execute()->getGraphObject(GraphUser::className());
			} catch (Exception $e) {
				Log::error('AuthController/postLoginWithFacebook/requestMe', (array) $e);
				return response()->api(400, 'Wrong access token', $data);
			}
		} else {
			return response()->api(400, 'Damaged access token', $data);
		}

		try {
			$p = (new FacebookRequest(
				$session, 'GET', '/me/picture?redirect=false&type=large'
			))->execute()->getGraphObject(GraphUser::className());
			$picture = (string) $p->getProperty('url');
		} catch (Exception $e) {
			$picture = null;
			Log::error('AuthController/postLoginWithFacebook/Picture', (array) $e);
		}

		$user_social_profile = DB::table('user_social_accounts')
			->where('source', 'facebook')
			->where('source_id', $me->getId())
			->first();

		$facebook_email = $me->getProperty('email');

		if (null === $facebook_email) {
			return response()->api(400, 'You need to verify your email on facebook.', $data);
		}

		$user = User::where('email', $facebook_email)->firstOrFail();

		$user_id = "";
		$email = "";

		if (is_null($user_social_profile)) {
			# we do not have this social account.
			if (is_null($user)) {
				# ok this is a complete new user, we need to register it.

				$email = $me->getProperty('email');
				/*
				register the required fields.
				 */
				$user = new User;
				$user->username = ((null !== $me->getProperty('username')) ? $this->checkUserNameUnique($me->getProperty('username')) : $this->checkUserNameUnique(Str::slug($me->getProperty('name'))));
				$user->email = $me->getProperty('email');
				$user->first_name = $me->getProperty('first_name');
				$user->last_name = $me->getProperty('last_name');

				try {
					$user->save();
					$op = 'register';
				} catch (Exception $e) {
					Log::error('AuthController/postLoginWithFacebook/UserSave', (array) $e);
					return response()->api(500, 'Cant save the user for the moment', $data);
				}
				$user_id = $user->id;
			} else {
				$user_id = $user->id;
				$email = $user->email;
			}

			#try to save user profile.

			$user_social_account = new UserSocialAccount;
			$user_social_account->user_id = $user_id;
			$user_social_account->source = "facebook";
			$user_social_account->source_id = $me->getId();
			$user_social_account->access_token = $data['access_token'];

			try {
				$user_social_account->save();
			} catch (Exception $e) {
				Log::error('AuthController/postLoginWithFacebook/SavingUserSocialAccount', (array) $e);
			}

		} else {
			$user_id = $user->id;
			$email = $user->email;
		}

		try {
			Auth::login($user);
			Request::merge(['grant_type' => 'direct', 'user_id' => $user->id]);
			$token = Authorizer::issueAccessToken();
		} catch (Exception $e) {
			Log::error('AuthController/postLoginWithFacebook', (array) $e);
			return response()->api(500, 'Error on generating OAuth token', ['details' => (array) $e]);
		}

		return response()->api(200, 'Logged in.', ['user' => $user, 'oauth2' => $token]);

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
