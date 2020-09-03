<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
     public $table = 'roles';
     protected $fillable = [
'name','role_type','guard_name'];
}
