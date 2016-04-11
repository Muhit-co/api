<?php namespace Muhit\Models;

class Announcement extends \Eloquent
{

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
