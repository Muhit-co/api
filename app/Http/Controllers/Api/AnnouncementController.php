<?php

namespace Muhit\Http\Controllers\Api;

use Muhit\Http\Controllers\Controller;
use Muhit\Repositories\User\UserRepositoryInterface;

class AnnouncementController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index($user_id)
    {
        return $this->userRepository->announcements($user_id);
    }
}