<?php namespace Muhit\Http\Controllers;

use Auth;
use Authorizer;
use Carbon\Carbon;
use Config;
use DB;
use Exception;
use Facebook\FacebookRequest;
use Facebook\FacebookSession;
use Facebook\GraphUser;
use Illuminate\Support\Str;
use Log;
use Mail;
use Muhit\Jobs\SignupConfirmation;
use Muhit\Models\Hood;
use Muhit\Models\User;
use Muhit\Models\UserSocialAccount;
use Request;
use Socialize;
use Storage;

class AuthController extends Controller
{

    public $redirPath;

    /**
     * setup the authController
     *
     * @return void
     * @author Me
     */
    public function __construct()
    {
        $last_page = session('last_page');
        if (empty($last_page) or $last_page == '/') {
            $this->redirPath = '/';
        } else {
            $this->redirPath = '/' . $last_page;
        }
    }

    /**
     * displays a login form
     *
     * @return view
     * @author gcg
     */
    public function getLogin()
    {

        if ($this->isApi) {
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

        if ($this->isApi) {
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
    public function postRegister()
    {
        $data = Request::all();

        $required_fields = ['email', 'first_name', 'last_name', 'password'];

        if ($this->isApi) {
            $required_fields[] = 'client_id';
            $required_fields[] = 'client_secret';
        }

        $register_url = '/register';
        if (isset($data['level']) and $data['level'] == 4) {
            $register_url = '/register-muhtar';
        }

        foreach ($required_fields as $key) {
            if (!isset($data[$key]) or empty($data[$key])) {
                if ($this->isApi) {
                    return response()->api(400, 'Missing fields, ' . $key . ' is required', $data);
                }
                return redirect($register_url)
                    ->with('error', trans('auth.fill_form_try_again'));
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
                    ->with('error', trans('auth.location_problem_try_again'))->withInput();
            }
        }

        $user = new User;

        $user->level = ((isset($data['level']) and $data['level'] == 4) ? 4 : 0);
        $user->admin_type = (isset($data['admin_type'])) ? $data['admin_type'] : null;

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

            return redirect($register_url)->with('warning', trans('auth.email_already_exists'))->withInput();
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
            $this->dispatch(new SignupConfirmation($user->id));
        } catch (Exception $e) {
            Log::error('AuthController/postRegister', (array) $e);
            if ($this->isApi) {
                return response()->api(500, 'Error while creating the user. ', ['details' => (array) $e]);
            }

            return redirect($register_url)->with('error', trans('auth.technical_problem'))->withInput();
        }

        if ($user->level === 4) {
            return redirect('/')->with('success', trans('auth.muhtar_access_requested'));
        }

        try {
            Auth::login($user);
        } catch (Exception $e) {
            Log::error('AuthController/postRegister', (array) $e);
            if ($this->isApi) {
                return response()->api(500, 'Login error on tech', []);
            }
            return redirect('/login')->with('warning', trans('auth.login_error_after_signup'))->withInput();
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

        // return redirect()->intended($this->redirPath)->with('success', 'Hoşgeldin, ' . $user->first_name)
        return redirect('/hosgeldin');
    }

    /**
     * login
     *
     * @return json
     * @author
     **/
    public function postLogin()
    {
        $data = Request::all();

        if ($this->isApi) {
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

            return redirect('/login')->with('warning', trans('auth.error_password'))->withInput();
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

        if (Auth::user()->level === 4) {
            Auth::logout();
            return redirect('/')->with('success', trans('auth.muhtar_access_requested'));
        }

        return redirect()->intended($this->redirPath)
            ->with('success', trans('auth.welcome') . ', ' . Auth::user()->first_name);
    }

    /**
     * login with facebook access token
     *
     * @return json
     * @author
     **/
    public function postLoginWithFacebook()
    {
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
                    $session,
                    'GET',
                    '/me'
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
                $session,
                'GET',
                '/me/picture?redirect=false&type=large'
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
    public function postSendPassword()
    {
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

    /**
     * redirects the user to facebook for access token
     *
     * @return redirect
     * @author Me
     */
    public function getFacebookLogin()
    {
        return Socialize::with('facebook')->redirect();
    }

    /**
     * logs in the user using facebook
     *
     * @return redirect
     * @author Me
     */
    public function getFacebookLoginReturn()
    {
        $user = Socialize::with('facebook')->user();

        $op = 'login';

        #check if we get the user with all the data that we need to login
        $email = $user->getEmail();
        $id = $user->getId();

        $userData = $user->user;

        if (empty($email) or empty($id)) {
            return redirect('/signup')
                ->with('error', trans('auth.error_facebook'))->withInput();
        }

        #check if the user already has an account with the facebook
        $user_social_account = DB::table('user_social_accounts')
            ->where('source', 'facebook')
            ->where('source_id', $id)
            ->first();

        if (empty($user_social_account)) {
            #lets register the user_social_account

            #check if the user is already have an account with the same email.
            $u = User::where('email', $email)->first();

            if (empty($u)) {
                #lets create the user account
                $op = 'register';

                if (isset($userData['name']) and !isset($userData['first_name'])) {
                    $parts = explode(" ", $userData['name']);
                    $userData['last_name'] = array_pop($parts);
                    $userData['first_name'] = implode(" ", $parts);
                }

                $u = new User;
                $u->username = Str::slug($user->getName());
                $u->email = $user->getEmail();
                $u->first_name = $userData['first_name'];
                $u->last_name = $userData['last_name'];
                $u->picture = $this->picture($user->avatar_original);
                $u->is_verified = ((isset($userData['verified']) and $userData['verified']) ? 1 : 0);
                try {
                    $u->save();
                } catch (Exception $e) {
                    Log::error('User save error', (array) $e);
                    return redirect('/signup')
                        ->with('error', trans('auth.technical_problem_registering'))->withInput();
                }
            }

            $user_social_account = new UserSocialAccount;
            $user_social_account->user_id = $u->id;
            $user_social_account->source = 'facebook';
            $user_social_account->source_id = $id;
            $user_social_account->access_token = $user->token;
            try {
                $user_social_account->save();
            } catch (Exception $e) {
                Log::error('AuthController/saveUserSocialAccount', (array) $e);
            }
        } else {
            $u = User::find($user_social_account->user_id);

            if (empty($u)) {
                DB::table('user_social_accounts')->where('id', $user_social_account->id)->delete();
                return redirect('/login/facebook');
            }
        }

        if ($u->picture == "placeholders/profile.png") {
            $u->picture = $this->picture($user->avatar_original);
            try {
                $u->save();
            } catch (Exception $e) {
                Log::error('AuthController/updateUserPicture', (array) $e);
            }
        }

        Auth::login($u);

        if ($op == 'login') {
            return redirect()
                ->intended($this->redirPath)
                ->with('success', trans('auth.welcome') . ', ' . $u->first_name . '!');
        }
        return redirect('/hosgeldin');
    }

    /**
     * get user picture from url and save it
     *
     * @return string
     * @author Me
     */
    public function picture($url = null)
    {
        $name = 'users/' . microtime(true);
        try {
            Storage::put($name, file_get_contents($url));
        } catch (Exception $e) {
            Log::error('Error while saving the user picture', (array) $e);
            return 'placeholders/profile.png';
        }

        return $name;
    }

    /**
     * sends an email to the user for reseting password
     *
     * @return void
     * @author Me
     */
    public function postForgotPassword()
    {
        if (!Request::has('email')) {
            return redirect('/forgot-password')
                ->with('error', trans('auth.email_try_again'))->withInput();
        }

        $user = User::where('email', Request::get('email'))->first();

        if (empty($user)) {
            return redirect('/forgot-password')
                ->with('error', trans('auth.email_not_found'))->withInput();
        }

        #create a random string as remember token.
        $string = bin2hex(mcrypt_create_iv(17, MCRYPT_DEV_URANDOM));
        $user->password_reset_token = $string;
        $user->password_token_expires_at = Carbon::now()->addDays(7);
        try {
            $user->save();
            Mail::send('emails.forgot_password', ['string' => $string, 'email' => $user->email], function ($m) use ($user) {
                $m->to($user->email)
                    ->subject(trans('auth.password_forgotten_email_title'));
            });
        } catch (Exception $e) {
            Log::error('AuthController/postForgotPassword', (array) $e);
            return redirect('/forgot-password')
                ->with('error', trans('auth.pw_forgot_cannot_send_mail'))->withInput();
        }
        return redirect('/')
            ->with('success', trans('auth.pw_forgot_email_sent'));
    }

    /**
     * checks the password token and displays a form for resetting a password
     *
     * @return view
     * @author Me
     */
    public function getResetPassword($email = null, $code = null)
    {
        if (empty($email) or empty($code)) {
            return redirect('/')
                ->with('error', trans('auth.invalid_link'));
        }

        $user = User::where('email', $email)
            ->where('password_reset_token', $code)
            ->where('password_token_expires_at', '>', Carbon::now())
            ->first();

        if (empty($user)) {
            return redirect('/')
                ->with('error', trans('auth.pw_forgot_invalid'));
        }

        return response()->app(200, 'auth.reset-password', ['user' => $user]);
    }

    /**
     * checks code again, and updates user password
     *
     * @return redirect
     * @author Me
     */
    public function postResetPassword()
    {
        if (!Request::has('email') or !Request::has('code') or !Request::has('password')) {
            return redirect('/')
                ->with('error', 'Geçersiz istek.')->withInput();
        }

        $user = User::where('email', Request::get('email'))
            ->where('password_reset_token', Request::get('code'))
            ->first();

        if (empty($user)) {
            return redirect('/')
                ->with('error', 'geçersiz istek')->withInput();
        }

        $user->password_reset_token = null;
        $user->password_token_expires_at = null;
        $user->password = bcrypt(Request::get('password'));

        try {
            $user->save();
            #TODO: maybe send an email to confirm password change.
        } catch (Exception $e) {
            Log::error('AuthController/postResetPassword', (array) $e);
            return redirect('/')
                ->with('error', trans('auth.pw_reset_error'))->withInput();
        }

        return redirect('/login')
            ->with('success', trans('auth.pw_reset_success'));
    }

    /**
     * checks the password token and displays a form for resetting a password
     *
     * @return view
     * @author Me
     */
    public function getConfirm($id = null, $code = null)
    {
        if (empty($id) or empty($code)) {
            return redirect('/')
                ->with('error', trans('auth.invalid_link'));
        }

        $user = User::where('id', $id)
            ->where('verify_token', $code)
            ->first();

        if (empty($user)) {
            return redirect('/')
                ->with('error', trans('auth.invalid_link'));
        }

        if ($user->is_verified == 0) {
            $user->is_verified = 1;
            try {
                $user->save();
            } catch (Exception $e) {
                Log::error('AuthController/getConfirm', (array) $e);
                return redirect('/')
                    ->with('error', trans('auth.account_confirm_error'));
            }
        }

        return redirect('/')
            ->with('success', trans('auth.account_confirm_success'));
    }
}
