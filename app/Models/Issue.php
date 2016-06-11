<?php namespace Muhit\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Redis;

class Issue extends \Eloquent
{

    use SoftDeletes;
    //

    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'user_id',
        'title',
        'status',
        'city_id',
        'district_id',
        'hood_id',
        'location',
        'is_anonymous',
        'coordinates',
        'supporter_count',
        'problem',
        'solution'
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(IssueImage::class);
    }

    public function updates()
    {
        return $this->hasMany(IssueUpdate::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function toArray($user_id = null)
    {
        $array = parent::toArray();
        $array['supporter_counter'] = (int)Redis::get('supporter_counter:' . $this->id);
        $array['is_supported'] = (((int)Redis::zscore('issue_supporters:' . $this->id, $user_id) > 0) ? 1 : 0);
        return $array;
    }

}
