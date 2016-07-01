<?php namespace Muhit\Models;

use Illuminate\Database\Eloquent\Model;

class UserSocialAccount extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'user_id',
        'source',
        'source_id',
        'access_token'
    ];
}
