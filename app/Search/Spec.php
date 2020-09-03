<?php

namespace App\Search;

use Algolia\ScoutExtended\Searchable\Aggregator;


class Spec extends Aggregator
{
    /**
     * The names of the models that should be aggregated.
     *
     * @var string[]
     */
    protected $models = [
        // ..
        \App\Speciality::class,
         \App\Service::class,
    ];

   	
}
