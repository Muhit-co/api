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
        $district = District::find($district_id);
        if(isset($district)){

            $popularIssues = Issue::where('district_id', $district_id)->orderBy('supporter_count', 'desc')->paginate(10);

            $hoodsOfDistrict = Hood::where('hoods.district_id', $district_id);

            $hoodsWithIssueCount = $hoodsOfDistrict->join('issues', 'hoods.id', '=', 'issues.hood_id')
            ->selectRaw('hoods.*, count(issues.hood_id) as issueCount')
            ->groupBy('issues.hood_id')
            ->get();

            return response()->app(200, 'reports.show', ['popularIssues' => $popularIssues, 'hoods' => $hoodsWithIssueCount, 'district' => $district]);
        }
        else  {
            return response()->app(404, 'errors.notfound', ['msg' => 'İlçe bulunamadı.']);

        }
}


}