<?php

namespace Muhit\Repositories\Issue;

use Illuminate\Http\Request;

interface IssueRepositoryInterface
{
    public function all(Request $request, $start, $end);

    public function get(Request $request, $id);

    public function create(Request $request);

    public function delete($user_id, $issue_id);

    public function supporters($issue_id);

    public function supported($user_id);

    public function created($user_id);
}