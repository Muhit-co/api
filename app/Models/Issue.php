<?php namespace Muhit\Models;

use Illuminate\Database\Eloquent\Model;
use Redis;

class Issue extends Model {

	//

	protected $guarded = ['id'];

	public function tags() {
		return $this->belongsToMany('Muhit\Models\Tag');
	}

	public function user() {
		return $this->belongsTo('Muhit\Models\User');
	}

	public function images() {
		return $this->hasMany('Muhit\Models\IssueImage');

    }

	public function toArray() {
		$array = parent::toArray();
		$array['supporter_counter'] = (int) Redis::get('supporter_counter:' . $this->id);
		return $array;
    }

}
