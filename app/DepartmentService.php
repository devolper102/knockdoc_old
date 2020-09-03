<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepartmentService extends Model
{
       public $table = 'department_services';
     protected $fillable = [
'department_id','service','description'];

public function departments()
    {
    	return $this->belongsTo('App\Department','department_id','id');
    }
}
