<?php

namespace App\Search;

use Algolia\ScoutExtended\Searchable\Aggregator;

class location extends Aggregator
{
    /**
     * The names of the models that should be aggregated.
     *
     * @var string[]
     */
    protected $models = [
        // ..
        \App\Location::class,
         \App\Area::class,
    ];
}
