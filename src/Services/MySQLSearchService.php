<?php

namespace App\Services;

use App\Interfaces\CommonSearchDriver;

class MySQLSearchService implements CommonSearchDriver
{
	/** 
	 * {@inheritDoc}
	 */
	public function findById($id)
	{
		return $this->findProduct($id);
	}

	/**
     * Built in method for fetching data from MySQL, which retrieves a product by its id
     *
     * @return CommonSearchDriver
     */
	protected function findProduct($id)
	{
		return [
            'type' => 'MySQL',
            'id' => $id,
            'product' => 'fakeProduct'
        ];
	}
}