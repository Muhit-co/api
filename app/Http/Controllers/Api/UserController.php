<?php

namespace Muhit\Http\Controllers\Api;

use Muhit\Http\Controllers\Controller;
use Muhit\Http\Requests\Api\Login;
use Muhit\Http\Requests\Api\Register;
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
}
