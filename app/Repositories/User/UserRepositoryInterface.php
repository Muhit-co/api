<?php

namespace Muhit\Repositories\User;

use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    public function register(Request $request);

    public function login($email, $password);

    public function profile($user_id);

    public function headman($user_id);

    public function announcements($user_id);

    public function update(Request $request, $user_id);

    public function facebookLogin(Request $request);
}