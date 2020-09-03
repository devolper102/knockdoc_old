<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    public $table = 'faqs';
    protected $fillable = ['status', 'description'];

    public function faqAssign() {
        return $this->belongsTo('App\FaqAssign', 'id', 'faq_id');
    }

}
