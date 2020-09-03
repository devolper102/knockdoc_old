<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Login_Account extends Model
{
      public $table = 'activities';
     protected $fillable = [
'user_name','ip_address'];

}
