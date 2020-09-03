<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Speciality_Test extends Model
{
        public $table = 'speciality_tests';
     protected $fillable = [
'name','speciality_id'];

public function specialities()
    {
    	return $this->belongsTo('App\Speciality','speciality_id','id');
    }

}
