<?php

namespace Muhit\Http\Controllers\Api;

use Muhit\Http\Controllers\Controller;
use Muhit\Http\Requests\Api\FacebookLogin;
use Muhit\Http\Requests\Api\Login;
use Muhit\Http\Requests\Api\Register;
use Muhit\Http\Requests\Api\UpdateUserInfo;
use Muhit\Repositories\User\UserRepositoryInterface;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(Register $request)
    {
        return $this->userRepository->register($request);
    }

    public function login(Login $request)
    {
        return $this->userRepository->login($request->get('email'), $request->get('password'));
    }

    public function profile($user_id)
    {
        return $this->userRepository->profile($user_id);
    }

    public function headman($user_id)
    {
        return $this->userRepository->headman($user_id);
    }

    public function update($user_id, UpdateUserInfo $updateUserInfo)
    {
        return $this->userRepository->update($updateUserInfo, $user_id);
    }

    public function announcements($user_id)
    {
        return $this->userRepository->announcements($user_id);
    }

    public function facebookLogin(FacebookLogin $facebookLogin)
    {
        return $this->userRepository->facebookLogin($facebookLogin);
    }
}
