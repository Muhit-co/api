<?php

namespace Muhit\Http\Controllers\Api;

use Muhit\Http\Controllers\Controller;
use Muhit\Repositories\Announcement\AnnouncementRepositoryInterface;

class AnnouncementController extends Controller
{
    protected $announcementRepository;

    public function __construct(AnnouncementRepositoryInterface $announcementRepository)
    {
        $this->announcementRepository = $announcementRepository;
    }

    public function index($hoodId, $start = 0, $end = 20)
    {
        $announcements =  $this->announcementRepository->getList($hoodId, $start, $end);

        return \ResponseService::createResponse('announcements', $announcements);
    }

}