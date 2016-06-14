<?php

namespace Muhit\Http\Controllers\Api;

use Illuminate\Http\Request;
use Muhit\Http\Controllers\Controller;
use Muhit\Http\Requests\Api\CreateIssue;
use Muhit\Repositories\Issue\IssueRepositoryInterface;

class IssueController extends Controller
{
    protected $issueRepository;

    public function __construct(IssueRepositoryInterface $issueRepository)
    {
        $this->issueRepository = $issueRepository;
    }

    public function issues(Request $request, $start = 0, $end = 10)
    {
        return $this->issueRepository->all($request, $start, $end);
    }

    public function issue($id, Request $request)
    {
        return $this->issueRepository->get($request, $id);
    }

    public function create(CreateIssue $request)
    {
        return $this->issueRepository->create($request);
    }

    public function delete($user_id, $issue_id)
    {
        return $this->issueRepository->delete($user_id, $issue_id);
    }

}