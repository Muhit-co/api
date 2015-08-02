<?php namespace Muhit\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model {

	//

	protected $guarded = ['id'];


    public function hoods() {
        return $this->hasMany('Muhit\Models\Hoods');
    }

    public function city() {
        return $this->belongsTo('Muhit\Models\City');
    }
}
