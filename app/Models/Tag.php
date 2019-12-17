<?php namespace Muhit\Models;

use DB;

class Tag extends \Eloquent
{

    protected $guarded = ['id'];
    protected $appends = ['issue_counter'];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function getIssueCounterAttribute() 
    {
        return DB::table('issue_tag')->where('tag_id', $this->id)->count();
    }
}
