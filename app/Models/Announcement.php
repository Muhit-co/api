<?php namespace Muhit\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model {

    //

    protected $guarded = ['id'];



    public function user() {
        return $this->belongsTo('Muhit\Models\User');
    }
}
