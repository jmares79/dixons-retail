<?php

namespace App\Interfaces;

interface FetcherInterface
{
	/**
	 * Retrieves from any data model the product by its id
	 *
	 * @param string $id
	 * @return array
	 */
	public function fetch($id);
}