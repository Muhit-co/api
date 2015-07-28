<?php namespace Muhit\Models;

use Illuminate\Database\Eloquent\Model;
use Redis;
use Illuminate\Database\Eloquent\SoftDeletes;

class Issue extends Model {

    use SoftDeletes;
    //

    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    public function tags() {
        return $this->belongsToMany('Muhit\Models\Tag');
    }

    public function user() {
        return $this->belongsTo('Muhit\Models\User');
    }

    public function images() {
        return $this->hasMany('Muhit\Models\IssueImage');

    }

    public function updates() {
        return $this->hasMany('Muhit\Models\IssueUpdate');

    }

    public function toArray() {
        $array = parent::toArray();
        $array['supporter_counter'] = (int) Redis::get('supporter_counter:' . $this->id);
        $array['is_supported'] = (((int) Redis::get('issue_supporters:'.$this->id) > 0 ) ? 1 : 0);
        return $array;
    }

}
