<?php namespace Muhit\Models;

class Comment extends \Eloquent
{

    protected $guarded = ['id'];
    protected $hidden = [
        'issue_id',
        'user_id',
    ];

    public function muhtar()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function issue()
    {
        return $this->belongsTo(Issue::class, 'issue_id');
    }
}
