<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vaccination extends Model
{
    public $table = 'vaccinations';
     protected $fillable = [
'name','description','url','duration'];

}
