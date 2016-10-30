<?php

namespace Muhit\Repositories\User;

use Auth;
use Authorizer;
use Config;
use DB;
use Exception;
use Facebook\FacebookRequest;
use Facebook\FacebookSession;
use Facebook\GraphUser;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Log;
use Muhit\Models\Announcement;
use Muhit\Models\Hood;
use Muhit\Models\User;
use Muhit\Models\UserSocialAccount;
use ResponseService;
use Storage;
use ToolService;

class UserRepository implements UserRepositoryInterface
{
    protected $user;
    protected $announcement;
    protected $userSocialAccount;

    public function __construct(User $user, Announcement $announcement, UserSocialAccount $userSocialAccount)
    {
        $this->user = $user;
        $this->announcement = $announcement;
        $this->userSocialAccount = $userSocialAccount;
    }

    public function register(Request $request)
    {
        $first_name = $request->get('first_name');
        $last_name = $request->get('last_name');
        $email = $request->get('email');

        if ($this->checkEmail($email) > 0) {

            return ResponseService::createErrorMessage('emailUnavailable');
        }

        $user = $this->user->create([
            'first_name' => $first_name,
            'email' => $email,
            'password' => bcrypt($request->get('password')),
            'last_name' => $last_name,
            'picture' => 'placeholders/profile.png',
            'username' => $this->generateUsername($first_name, $last_name),
            'api_token' => ToolService::generateApiToken()
        ]);

        return ResponseService::createResponse('user', $user);
    }

    private function checkEmail($email)
    {
        return $this->user->where('email', $email)->count();
    }

    private function generateUsername($first_name, $last_name)
    {
        $username = Str::lower("{$first_name}.{$last_name}");

        if ($this->getUsernameCount($username) == 0) {

            return $username;
        }

        do {

            $username = $username . '-' . rand(0, 100);

        } while ($this->getUsernameCount($username) > 0);

        return $username;
    }

    private function getUsernameCount($username)
    {
        return $this->user->where('username', $username)->count();
    }

    public function login($email, $password)
    {
        $user = $this->user->where('email', $email)->first();

        if (!$user || !Auth::attempt(['email' => $email, 'password' => $password])) {

            return ResponseService::createErrorMessage('invalidLogin');
        }

        if (!$user->api_token) {

            $user->api_token = ToolService::generateApiToken();
            $user->save();
        }

        return ResponseService::createResponse('user', $user);
    }

    public function profile($user_id)
    {
        $user = $this->user->with('issues')
            ->where('id', $user_id)
            ->first([
                'username',
                'email',
                'id',
                'first_name',
                'last_name',
                'level',
                'picture'
            ]);

        if (!$user) {

            return ResponseService::createErrorMessage('userNotFound');
        }

        return ResponseService::createResponse('user', $user);
    }

    public function headman($user_id)
    {
        $user = $this->user->where('id', $user_id)->first(['hood_id']);

        if (!$user) {

            return ResponseService::createErrorMessage('userNotFound');
        }

        if (!$user->hood_id) {

            return ResponseService::createErrorMessage('headManNotFound');
        }

        $headMan = $this->user->where('level', 5)
            ->where('hood_id', $user->hood_id)
            ->first([
                'username',
                'email',
                'id',
                'first_name',
                'last_name',
                'level',
                'picture',
                'phone',
                'location',
                'coordinates'
            ]);

        if (!$headMan) {

            return ResponseService::createErrorMessage('headManNotFound');
        }

        return ResponseService::createResponse('headMan', $headMan);
    }

    public function announcements($user_id)
    {
        $user = $this->user->where('id', $user_id)->first(['hood_id']);

        if (!$user) {

            return ResponseService::createErrorMessage('userNotFound');
        }

        if (!$user->hood_id) {

            return ResponseService::createResponse('announcements', []);
        }

        $announcements = $this->announcement->with('user')
            ->where('hood_id', $user->hood_id)
            ->orderBy('id', 'desc')
            ->get();

        return ResponseService::createResponse('announcements', $announcements);
    }

    public function facebookLogin(Request $request)
    {
        $facebookClientId = Config::get('services.facebook.client_id');
        $facebookClientSecret = Config::get('services.facebook.client_secret');

        FacebookSession::setDefaultApplication($facebookClientId, $facebookClientSecret);

        try {

            $session = new FacebookSession($request->get('access_token'));

        } catch (Exception $e) {

            Log::error('AuthController/postLoginWithFacebook', (array)$e);

            return ResponseService::createErrorMessage('facebookInvalidAccessToken');
        }

        try {

            $me = (new FacebookRequest($session, 'GET', '/me'))->execute()->getGraphObject(GraphUser::className());

        } catch (Exception $e) {

            Log::error('AuthController/postLoginWithFacebook/requestMe', (array)$e);

            return ResponseService::createErrorMessage('facebookInvalidAccessToken');
        }

        $user_social_profile = DB::table('user_social_accounts')
            ->where('source', 'facebook')
            ->where('source_id', $me->getId())
            ->first();

        $facebook_email = $me->getProperty('email');

        if (!$facebook_email) {

            return ResponseService::createErrorMessage('facebookEmailVerification');
        }

        $user = $this->user->where('email', $facebook_email)->first();

        if (!$user_social_profile) {

            if (!$user) {

                try {

                    $this->user->create([
                        'first_name' => $me->getProperty('first_name'),
                        'email' => $me->getProperty('email'),
                        'password' => bcrypt($request->get('password')),
                        'last_name' => $me->getProperty('last_name'),
                        'picture' => 'placeholders/profile.png',
                        'username' => $this->generateUsername($me->getProperty('first_name'),
                            $me->getProperty('last_name')),
                        'api_token' => ToolService::generateApiToken()
                    ]);

                } catch (Exception $e) {

                    Log::error('AuthController/postLoginWithFacebook/UserSave', (array)$e);

                    return ResponseService::createErrorMessage('facebookSaveError');
                }

                $user_id = $user->id;

            } else {
                $user_id = $user->id;
            }

            $this->userSocialAccount->create([
                'user_id' => $user_id,
                'source' => 'facebook',
                'source_id' => $me->getId(),
                'access_token' => $request->get('access_token')
            ]);
        }

        return ResponseService::createResponse('user', $user);
    }

    public function update(Request $request, $user_id)
    {
        $user = $this->user->where('id', $user_id)->first();

        if (!$user) {

            return ResponseService::createErrorMessage('userNotFound');
        }

        if ($request->has('email') && filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {

            $user->email = $request->get('email');
            $user->is_verified = 0;
        }

        $location_parts = explode(",", $request->get('active_hood'));
        $hood = false;

        if (count($location_parts) === 3) {

            $hood = Hood::fromLocation($request->get('active_hood'));
        }

        if (isset($hood) && isset($hood->id)) {

            $user->hood_id = $hood->id;
        }

        if ($request->has('email') && $request->get('email') != $user->email) {

            $checkEmail = $this->user->where('email', $request->get('email'))->first();

            if ($checkEmail && $checkEmail->id != $user_id) {

                return ResponseService::createErrorMessage('emailUnavailable');
            }

            $user->email = $request->get('email');
        }

        if ($request->has('username') && $request->get('username') != $user->username) {

            $checkUsername = $this->user->where('username', $request->get('username'))->first();

            if ($checkUsername && $checkUsername->id != $user_id) {

                return ResponseService::createErrorMessage('usernameUnavailable');
            }

            $user->username = $request->get('username');
        }

        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->location = $request->get('location');

        if ($request->has('picture') && Str::length($request->get('picture')) > 0) {

            try {

                $name = str_replace('.', '', microtime(true));
                Storage::put('users/' . $name, base64_decode($request->get('picture')));
                $user->picture = $name;

            } catch (Exception $e) {

                throw new $e;
            }
        }

        try {

            $user->save();

        } catch (Exception $e) {

            Log::error('MemberController/postUpdate', (array)$e);

            return ResponseService::createErrorMessage('exceptionOccurredSavingProfile');
        }

        return ResponseService::createSuccessMessage('profileUpdated');
    }
}