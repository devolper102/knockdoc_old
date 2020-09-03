<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FaqAssign extends Model
{
    public $table = 'faq_assign';
    protected $fillable = ['faq_id', 'assign_value', 'type'];

    public function faqs() {
        return $this->belongsTo('App\Faq', 'faq_id', 'id');
    }

}
