<?php namespace Muhit\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Redis;

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

	public function comments() {
		return $this->hasMany('Muhit\Models\Comment');

	}

	public function toArray($user_id = null) {
		$array = parent::toArray();
		$array['supporter_counter'] = (int) Redis::get('supporter_counter:' . $this->id);
		$array['is_supported'] = (((int) Redis::zscore('issue_supporters:' . $this->id, $user_id) > 0) ? 1 : 0);
		return $array;
	}

}
