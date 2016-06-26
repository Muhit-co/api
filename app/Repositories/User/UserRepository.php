<?php

namespace Muhit\Repositories\User;

use Auth;
use Authorizer;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Muhit\Models\User;
use ResponseService;
use ToolService;

class UserRepository implements UserRepositoryInterface
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
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

            return ResponseService::createResponse('headman', []);
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
}