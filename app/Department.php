<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public $table = 'departments';
     protected $fillable = [
'name','description'];

public function departmentservice()
    {
    	return $this->hasMany('App\DepartmentService');
    }
}
