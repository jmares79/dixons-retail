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
        //TODO simulates a GET product/<id>
        return [
            '_source' => [
                'type' => 'ElasticSearch',
                'id' => $id,
                'product' => 'fakeProduct'
            ]
        ];
    }
}
