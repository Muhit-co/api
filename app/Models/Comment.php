<?php namespace Muhit\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

	//
	protected $guarded = ['id'];

	public function muhtar() {
		return $this->belongsTo('Muhit\Models\User', 'user_id');

	}

	public function issue() {
		return $this->belongsTo('Muhit\Models\Issue', 'issue_id');

	}
}
