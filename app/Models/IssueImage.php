<?php namespace Muhit\Models;


class IssueImage extends \Eloquent
{
    protected $guarded = ['id'];
    protected $hidden = [
        'created_at',
        'updated_at',
        'issue_id',
    ];
}
