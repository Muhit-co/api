<?php

namespace Muhit\Repositories\Admin;

use Illuminate\Http\Request;

interface AdminRepositoryInterface
{
    public function getMembers(Request $request);

    public function getMember($id);

    public function getUpdates($id);

    public function rejectMuhtar($member);

    public function approveMuhtar($member);
}