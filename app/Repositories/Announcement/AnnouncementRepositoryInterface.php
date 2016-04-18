<?php

namespace Muhit\Repositories\Announcement;

use Illuminate\Http\Request;

interface AnnouncementRepositoryInterface
{
    public function getList($hoodId, $start, $take);

    public function create(Request $request);
}
