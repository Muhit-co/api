<?php namespace Muhit\Http\Controllers;
/**
 * Created by PhpStorm.
 * User: aniluygun
 * Date: 03/09/17
 * Time: 19:44
 */



use DB;
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

            $popularIssues = $this->getIssuesByDistrictAndStatus($district_id, 'all');
            $hoodsOfDistrictWithIssueCount = $this->getHoodsOfDistrictWithIssueCount($district_id);
            $ideaChartData = $this->getIdeaChartData($district_id);
            $tagsOfDistrictWithIssueCount = $this->getTagsOfDistrictWithIssueCount($district_id, null);
            $issueCount = $this->getIssueCountOfDistrict($district_id);

            return response()->app(200, 'reports.show', ['popularIssues' => $popularIssues, 'hoods' => $hoodsOfDistrictWithIssueCount, 'district' => $district, 'ideaChartData' => $ideaChartData, 'tags' => $tagsOfDistrictWithIssueCount, 'issueCount'=>$issueCount]);
          
        }
        else  {
            return response()->app(404, 'errors.notfound', ['msg' => 'İlçe bulunamadı.']);

        }
    }

    public function getReportDistrictIssues($district_id = null){
        $district = District::find($district_id);
        $issue_status = request()->input('issueStatus');
        $tag_id = request()->input('tagId');

        if(!isset($issue_status)){
            $issue_status = 'all';
        }

        if(isset($district) && isset($issue_status) ) {
            if($tag_id){
                $popularIssues = $this->getIssuesByDistrictAndStatusAndTag($district_id, $issue_status, $tag_id);
            } else {
                $popularIssues = $this->getIssuesByDistrictAndStatus($district_id, $issue_status);
            }
            return response()->app(200, 'partials.report-issues', ['popularIssues' => $popularIssues]);
        }
    }

    private function getIssueCountOfDistrict($district_id){
        return DB::table('issues')
            ->where('district_id', $district_id)->whereNull('deleted_at') ->count();
    }

    private function getIssuesByDistrictAndStatus($district_id, $issue_status)
    {
        if (isset($district_id) && isset($issue_status)) {

            $query = 'select id, title, status, supporter_count
            from issues 
            where district_id = :district_id
            and ( \'all\' = :issue_status or status = :issue_status_1)
            and deleted_at is NULL
            order by supporter_count desc
            limit 10';

            return DB::select($query, ['district_id' => $district_id, 'issue_status' => $issue_status,'issue_status_1' => $issue_status]);
        }
    }
    private function getIssuesByDistrictAndStatusAndTag($district_id, $issue_status, $tag_id)
    {
        if (isset($district_id) && isset($issue_status) && isset($tag_id)) {

            $query = 'select i.id, i.title, i.status, i.supporter_count
            from issues i
            join issue_tag it on i.id = it.issue_id
            where district_id = :district_id
            and ( \'all\' = :issue_status or i.status = :issue_status_1)
            and it.tag_id = :tag_id
            and i.deleted_at is NULL
            order by supporter_count desc
            limit 10';

            return DB::select($query, ['district_id' => $district_id, 'issue_status' => $issue_status,'issue_status_1' => $issue_status, 'tag_id'=>$tag_id]);
        }
    }

    private function getHoodsOfDistrictWithIssueCount($district_id){
        $hoodsOfDistrict = Hood::where('hoods.district_id', $district_id);
        return $hoodsOfDistrict->join('issues', 'hoods.id', '=', 'issues.hood_id')
            ->whereNull('issues.deleted_at')
            ->selectRaw('hoods.*, count(issues.hood_id) as issueCount')
            ->groupBy('issues.hood_id')
            ->orderBy('issueCount','desc')
            ->get();
    }

    private function getIdeaChartData($district_id){
        $query = 'select status, count(*) as statusCount
            from issues 
            where district_id = :district_id
            and deleted_at is NULL
            group by status';

        $allIssuesStatusGroup = DB::select($query, ['district_id' => $district_id]);
        $ideaChartData = [["Fikir durumu", "Meblağ", "status"]];
        foreach ($allIssuesStatusGroup as $issueStatus){
            array_push($ideaChartData, [trans('issues.'.$issueStatus->status), $issueStatus->statusCount, $issueStatus->status]);
        }

        return $ideaChartData;
    }

    private function getTagsOfDistrictWithIssueCount($district_id, $tag_id){
        $query = 'select t.id, t.name, t.background, count(it.tag_id) as issueCount 
                    from issues i
                    join issue_tag it on i.id = it.issue_id
                    join tags t on t.id = it.tag_id
                    where i.district_id = :district_id
                    and i.deleted_at is NULL';

        if(isset($tag_id)){
            $query .= ' and t.id = :tag_id';
        }
        $query .= ' group by it.tag_id
                    order by issueCount';

        if(isset($tag_id)){
            return DB::select($query, ['district_id' => $district_id, 'tag_id'=> $tag_id]);

        } else {
            return DB::select($query, ['district_id' => $district_id]);
        }
    }
}