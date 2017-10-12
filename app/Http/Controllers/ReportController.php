<?php namespace Muhit\Http\Controllers;
/**
 * Created by PhpStorm.
 * User: aniluygun
 * Date: 03/09/17
 * Time: 19:44
 */




use Muhit\Models\District;
use Muhit\Models\Issue;
use Muhit\Models\Hood;

class ReportController extends Controller
{
    /**
     *
     */
    public function getReportDistrictById($district_id = null)
    {
        $popularIssues = Issue::where('district_id', $district_id)->orderBy('supporter_count', 'desc')->paginate(10);

       // $district = District::with('hoods')->get();
       // $district->where('id', $district_id);

        $district = District::find($district_id);//where('id', $district_id)->get();


        $hoodsOfDistrict = Hood::where('hoods.district_id', $district_id);


       /* DB::table('website_tags')
            ->join('assigned_tags', 'website_tags.id', '=', 'assigned_tags.tag_id')
            ->select('website_tags.id as id', 'website_tags.title as title', DB::raw("count(assigned_tags.tag_id) as count"))-
>get();*/


        $hoodsWithIssueCount = $hoodsOfDistrict->join('issues', 'hoods.id', '=', 'issues.hood_id')
        ->selectRaw('hoods.*, count(issues.hood_id) as issueCount')
        ->groupBy('issues.hood_id')
        ->get();

        return response()->app(200, 'reports.show', ['popularIssues' => $popularIssues, 'hoods' => $hoodsWithIssueCount, 'district' => $district]);

    }


}