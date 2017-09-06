<?php namespace Muhit\Http\Controllers;
/**
 * Created by PhpStorm.
 * User: aniluygun
 * Date: 03/09/17
 * Time: 19:44
 */




use Muhit\Models\Issue;

class ReportController extends Controller
{
    /**
     *
     */
    public function getReport()
    {
        $popularIssues = Issue::orderBy('supporter_count', 'desc')->paginate(10);

        return response()->app(200, 'reports.show', ['popularIssues' => $popularIssues]);

    }
}