<?php namespace Muhit\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Redis;

class User extends \Eloquent implements AuthenticatableContract
{

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
    protected $fillable = [
        'first_name',
        'email',
        'password',
        'last_name',
        'picture',
        'username',
        'api_token',
        'hood_id',
        'location'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'password_reset_token',
        'password_token_expires_at',
    ];

    protected $appends = ['full_name', 'profile_photo'];

    public function hood()
    {
        return $this->belongsTo(Hood::class);
    }

    public function issues()
    {
        return $this->hasMany(Issue::class);
    }

    public function getFullNameAttribute()
    {
        return Str::ucfirst($this->first_name) . " " . Str::ucfirst($this->last_name);
    }

    public function getProfilePhotoAttribute()
    {
        return "//d1vwk06lzcci1w.cloudfront.net/80x80/" . $this->picture;
    }

    public function toArray()
    {
        $array = parent::toArray();
        $array['opened_issue_counter'] = (int)Redis::get('user_opened_issue_counter:' . $this->id);
        $array['supported_issue_counter'] = (int)Redis::get('user_supported_issue_counter:' . $this->id);

        return $array;
    }

}
