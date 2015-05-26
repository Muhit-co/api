<?php namespace Muhit\Models;

use Illuminate\Database\Eloquent\Model;

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

}
