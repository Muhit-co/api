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
use Muhit\Models\Tag;

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
            $hoodsOfDistrictWithIssueCount = $this->getHoodsOfDistrictWithIssueCount($district_id);
            $ideaChartData = $this->getIdeaChartData($district_id);
            $tagsOfDistrictWithIssueCount = $this->getTagsOfDistrictWithIssueCount($district_id, null);

            return response()->app(200, 'reports.show', ['popularIssues' => $popularIssues, 'hoods' => $hoodsOfDistrictWithIssueCount, 'district' => $district, 'ideaChartData' => $ideaChartData, 'tags' => $tagsOfDistrictWithIssueCount]);
          
        }
        else  {
            return response()->app(404, 'errors.notfound', ['msg' => 'İlçe bulunamadı.']);

        }
    }

    public function getReportDistrictIssues($district_id = null){
        $district = District::find($district_id);
        $issue_status = request()->input('issueStatus');
        if(isset($district) && isset($issue_status)) {

            $popularIssues = Issue::where('district_id', $district_id);

            if($issue_status != 'all'){
                $popularIssues = $popularIssues->where('status', $issue_status);
            }

            $popularIssues = $popularIssues->orderBy('supporter_count', 'desc')
                ->paginate(10);

            return response()->app(200, 'partials.report-issues', ['popularIssues' => $popularIssues]);
        }
    }

    public function getReportDistrictTags($district_id = null){
        $district = District::find($district_id);
        $tag_id = request()->input('tagId');
        if(isset($district) ) {
            $filteredTags = $this->getTagsOfDistrictWithIssueCount($district_id, $tag_id);

            return response()->app(200, 'partials.report-tags', ['tags' => $filteredTags]);
        }
    }

    private function getHoodsOfDistrictWithIssueCount($district_id){
        $hoodsOfDistrict = Hood::where('hoods.district_id', $district_id);
        return $hoodsOfDistrict->join('issues', 'hoods.id', '=', 'issues.hood_id')
            ->selectRaw('hoods.*, count(issues.hood_id) as issueCount')
            ->groupBy('issues.hood_id')
            ->orderBy('issueCount','desc')
            ->get();
    }

    private function getIdeaChartData($district_id){
        $allIssuesStatusGroup = Issue::where('district_id', $district_id)
            ->selectRaw('issues.status, count(*) as statusCount')
            ->groupBy('issues.status')
            ->get();
        $ideaChartData = [["Fikir durumu", "Meblağ", "status"]];
        foreach ($allIssuesStatusGroup as $issueStatus){
            array_push($ideaChartData, [trans('issues.'.$issueStatus['status']), $issueStatus['statusCount'], $issueStatus['status']]);
        }

        return $ideaChartData;
    }

    private function getTagsOfDistrictWithIssueCount($district_id, $tag_id){
        $query = Issue::where('district_id', $district_id)
            ->join('issue_tag', 'issues.id', '=', 'issue_tag.issue_id')
            ->join('tags', 'issue_tag.tag_id', '=', 'tags.id')
            ->selectRaw('tags.id, tags.name, tags.background, count(issue_tag.tag_id) as issueCount');

        if(isset($tag_id)){
            $query->where('tags.id', $tag_id);
        }

        return $query->groupBy('issue_tag.tag_id')
            ->orderBy('issueCount','desc')
            ->get();

    }
}