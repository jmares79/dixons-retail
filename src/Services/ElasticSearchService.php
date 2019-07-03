<?php

namespace App\Services;

use App\Interfaces\CommonSearchDriver;

class ElasticSearchService implements CommonSearchDriver
{
    /** 
     * {@inheritDoc}
     */
    public function findById($id)
    {
        return [
            'type' => 'ElasticSearch',
            'id' => $id,
            'product' => 'fakeProduct'
        ];
    }
}
