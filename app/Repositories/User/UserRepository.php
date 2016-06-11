<?php

namespace Muhit\Repositories\User;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Muhit\Models\User;

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

        if($this->checkEmail($email) > 0){

            return response()->api(200, 'Email address exist');
        }

        $user = $this->user->create([
            'first_name' => $first_name,
            'email' => $email,
            'password' => bcrypt($request->get('password')),
            'last_name' => $last_name,
            'picture' => 'placeholders/profile.png',
            'username' => $this->generateUsername($first_name, $last_name),
        ]);

        $user->picture = "//d1vwk06lzcci1w.cloudfront.net/80x80/" . $user->picture;

        return response()->api(200, 'User', $user);
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

    private function checkEmail($email)
    {
        return $this->user->where('email', $email)->count();
    }
}