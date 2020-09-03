<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diagnose extends Model
{
        public $table = 'diagnosis';
     protected $fillable = [
'name','speciality_id'];

public function specialities()
    {
    	return $this->belongsTo('App\Speciality','speciality_id','id');
    }

}
