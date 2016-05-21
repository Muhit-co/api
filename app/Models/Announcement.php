<?php namespace Muhit\Models;

class Announcement extends \Eloquent
{

    protected $guarded = ['id'];

    protected $fillable = [
        'hood_id',
        'location',
        'title',
        'content',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
