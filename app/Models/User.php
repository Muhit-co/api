<?php namespace Muhit\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Redis;

class User extends Model implements AuthenticatableContract {

    use Authenticatable;

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
