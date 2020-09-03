<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
     public $table = 'facilities';
     protected $fillable = [
'name','description'];
}
