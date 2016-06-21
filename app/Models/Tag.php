<?php namespace Muhit\Models;

use Redis;

class Tag extends \Eloquent
{

    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'background'
    ];

    public function toArray()
    {
        $array = parent::toArray();
        $array['issue_counter'] = (int)Redis::get('tag_issue_counter:' . $this->id);

        return $array;
    }
}
