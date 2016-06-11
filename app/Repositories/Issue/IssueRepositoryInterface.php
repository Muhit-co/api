<?php

namespace Muhit\Repositories\Issue;

use Illuminate\Http\Request;

interface IssueRepositoryInterface
{
    public function all(Request $request, $start, $end);

    public function get(Request $request, $id);

    public function create(Request $request);

}