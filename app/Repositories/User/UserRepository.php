<?php

namespace Muhit\Repositories\User;

use Auth;
use Authorizer;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Muhit\Models\Announcement;
use Muhit\Models\User;
use ResponseService;
use ToolService;

class UserRepository implements UserRepositoryInterface
{
    protected $user;
    protected $announcement;

    public function __construct(User $user, Announcement $announcement)
    {
        $this->user = $user;
        $this->announcement = $announcement;
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
                'phone'
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

    public function update(Request $request, $user_id)
    {
        $user = $this->user->where('id', $user_id)->first();

        if (!$user) {

            return ResponseService::createErrorMessage('userNotFound');
        }

        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');

        if ($request->get('email') != $user->email) {

            $checkEmail = $this->user->where('email', $request->get('email'))->first();

            if (!$checkEmail) {

                $user->email = $request->get('email');

            } else {

                if ($checkEmail->id != $user_id) {

                    return ResponseService::createErrorMessage('emailUnavailable');
                }
            }
        }

        if ($request->get('username') != $user->username) {

            $checkUsername = $this->user->where('username', $request->get('username'))->first();

            if (!$checkUsername) {

                $user->username = $request->get('username');

            } else {

                if ($checkUsername->id != $user_id) {

                    return ResponseService::createErrorMessage('usernameUnavailable');
                }
            }
        }

        $user->save();

        return ResponseService::createSuccessMessage('userInfoUpdated');
    }
}