<?php namespace Muhit\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

	//
	protected $guarded = ['id'];

	public function muhtar() {
		return $this->belongsTo('Muhit\Models\User');

	}
}
