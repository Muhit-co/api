<?php

namespace Muhit\Http\Controllers\Api;

use Illuminate\Http\Request;
use Muhit\Http\Controllers\Controller;
use Muhit\Http\Requests\Api\CreateIssue;
use Muhit\Http\Requests\Api\Support;
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

    public function supporters($issue_id)
    {
        return $this->issueRepository->supporters($issue_id);
    }

    public function supported($user_id)
    {
        return $this->issueRepository->supported($user_id);
    }

    public function created($user_id)
    {
        return $this->issueRepository->created($user_id);
    }

    public function support($issue_id, Support $support)
    {
        return $this->issueRepository->support($issue_id, $support->get('user_id'));
    }

    public function unsupport($issue_id, Support $support)
    {
        return $this->issueRepository->unsupport($issue_id, $support->get('user_id'));
    }
}