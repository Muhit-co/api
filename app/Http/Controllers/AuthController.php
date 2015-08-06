<?php namespace Muhit\Http\Controllers;

use Auth;
use Authorizer;
use Config;
use DB;
use Facebook\FacebookRequest;
use Facebook\FacebookSession;
use Facebook\GraphUser;
use Illuminate\Support\Str;
use Log;
use Muhit\Http\Controllers\Controller;
use Muhit\Models\User;
use Muhit\Models\Hood;
use Muhit\Models\UserSocialAccount;
use Request;


class AuthController extends Controller {

    /**
     * displays a login form
     *
     * @return view
     * @author gcg
     */
    public function getLogin()
    {

        if($this->isApi){
            return response()->api(404, 'Method not found', []);
        }

        return response()->app(200, 'auth.login');
    }

    /**
     * displays a registration form
     *
     * @return view
     * @author gcg
     */
    public function getRegister()
    {

        if($this->isApi){
            return response()->api(404, 'Method not found', []);
        }

        return response()->app(200, 'auth.register');
    }

    /**
     * register as a new user
     *
     * @return json
     * @author
     **/
    public function postRegister() {
        $data = Request::all();

        if ($this->isApi) {
            $required_fields = ['email', 'first_name', 'last_name', 'password', 'client_id', 'client_secret'];
            foreach ($required_fields as $key) {
                if (!isset($data[$key]) or empty($data[$key])) {
                    return response()->api(400, 'Missing fields, ' . $key . ' is required', $data);
                }

            }
        }


        #lets figure out the location.
        $location_parts = explode(",", $data['location']);
        $hood = false;
        if (count($location_parts) === 3) {
            $hood = Hood::fromLocation($data['location']);
        }

        if ($hood === false or $hood === null or !isset($hood->id) or !isset($hood->city_id) or !isset($hood->district_id)) {

            if (isset($data['level']) and $data['level'] == 4) {
                if ($this->isApi) {
                    return response()->api(401, 'Cant get the hood information from the location provided.', ['data' => $data]);
                }
                return redirect('/register-muhtar')
                    ->with('error', 'Lokasyonunuzu girerken bir hata oldu, lütfen tekrar deneyin.');
            }
        }


        $user = new User;

        $user->level = ((isset($data['level']) and $data['level'] == 4) ? 4 : 0);

        if (!isset($data['username'])) {
            $data['username'] = '';
        }

        $data['username'] = Str::slug($data['username']);
        if (empty($data['username'])) {
            $data['username'] = Str::slug($data['first_name']) . "-" . Str::slug($data['last_name']);
        }

        $check_username = DB::table('users')->where('username', $data['username'])->first();
        $check_email = DB::table('users')->where('email', $data['email'])->first();

        if (null !== $check_email) {
            Log::error('Auth/Register/DuplicateEmail', $data);
            if ($this->isApi) {
                return response()->api(400, 'Duplicate entry on email.', $data);
            }

            return redirect('/register')->with('warning', 'Bu eposta adresi ile daha önceden kayıt olunmuş, şifreni unuttuysan, şifreni hatırlatabilirim? ');
        }

        if (null !== $check_username) {
            $data['username'] = $data['username'] . time();
        }

        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];

        if (isset($hood) and isset($hood->id)) {
            $user->hood_id = $hood->id;
            $user->location = $data['location'];
        }


        try {
            $user->save();
        } catch (Exception $e) {
            Log::error('AuthController/postRegister', (array) $e);
            if ($this->isApi) {
                return response()->api(500, 'Error while creating the user. ', ['details' => (array) $e]);
            }

            return redirect('/register')->with('error', 'Teknik bir sıkıntı oldu :(  ');

        }

        try {
            Auth::login($user);
        } catch (Exception $e) {
            Log::error('AuthController/postRegister', (array) $e);
            if ($this->isApi) {
                return response()->api(500, 'Login error on tech', []);
            }
            return redirect('/login')->with('warning', 'Kayıttan sonra oturum açarken bir hata oluştu.');
        }

        if ($this->isApi) {
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

       return redirect('/')->with('success', 'Hoşgeldin, '.$user->first_name);

    }

    /**
     * login
     *
     * @return json
     * @author
     **/
    public function postLogin() {
        $data = Request::all();

        if($this->isApi){
            $required_fields = ['email', 'password', 'client_id', 'client_secret'];

            foreach ($required_fields as $key) {
                if (!isset($data[$key]) or empty($data[$key])) {
                    return response()->api(400, 'Missing fields, ' . $key . ' is required', $data);
                }

            }
        }

        if (!Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {

            if ($this->isApi) {
                return response()->api(401, 'Wrong user credentials', $data);
            }

            return redirect('/login')->with('warning', 'Şifreni unutmuş olabilir misin? ');
        }

        if ($this->isApi) {
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

        return redirect('/')->with('success', 'Hoşgeldin, '.Auth::user()->first_name);

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

    /**
     * refresh the access token with the refresh token
     *
     * @return json
     * @author gcg
     */
    public function postRefreshToken()
    {
        $data = Request::all();
        $required_fields = ['refresh_token', 'client_id', 'client_secret'];

        foreach ($required_fields as $key) {
            if (!isset($data[$key]) or empty($data[$key])) {
                return response()->api(400, 'Missing fields, ' . $key . ' is required', $data);
            }
        }

        Request::merge(['grant_type' => 'refresh_token']);
        try {
            $token = Authorizer::issueAccessToken();
        } catch (Exception $e) {
            Log::error('AuthController/postRefreshToken', (array) $e);
            return response()->api(500, 'Tech problem', []);
        }
        return response()->api(200, 'Access token refreshed', ['oauth2' => $token]);
    }

}
