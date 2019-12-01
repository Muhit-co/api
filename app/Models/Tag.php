<?php namespace Muhit\Models;

use DB;

class Tag extends \Eloquent
{

    protected $guarded = ['id'];
    protected $appends = ['issue_counter'];

    public function getIssueCounterAttribute() 
    {
        return DB::table('issue_tag')->where('tag_id', $this->id)->count();
    }
}
