<?php

namespace Muhit\Http\Controllers;

use Muhit\Http\Requests\Api\Register;
use Muhit\Repositories\User\UserRepositoryInterface;

class ApiController extends Controller
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
}
