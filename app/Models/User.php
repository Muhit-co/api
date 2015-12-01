<?php namespace Muhit\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Redis;

class User extends Model implements AuthenticatableContract {

	use Authenticatable;
	use SoftDeletes;

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = ['deleted_at'];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['first_name', 'email', 'password', 'last_name', 'picture', 'username'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token', 'level'];

	public function hood() {
		return $this->belongsTo('Muhit\Models\Hood');
	}

	public function issues() {
		return $this->hasMany('Muhit\Models\Issue');
	}

	public function toArray() {
		$array = parent::toArray();
		$array['opened_issue_counter'] = (int) Redis::get('user_opened_issue_counter:' . $this->id);
		$array['supported_issue_counter'] = (int) Redis::get('user_supported_issue_counter:' . $this->id);
		return $array;
	}

}
