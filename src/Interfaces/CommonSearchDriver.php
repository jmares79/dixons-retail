<?php

namespace App\Interfaces;

interface CommonSearchDriver
{
	/**
	 * Retrieves a product by its id from the data model
	 *
	 * @param string $id
	 * @return array
	 */
	public function findById($id);
}
