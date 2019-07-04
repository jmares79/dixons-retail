<?php

namespace App\Interfaces;

interface CacheInterface
{
	/**
	 * Checks whether there's an item on the cache or not
	 *
	 * @param string $id
	 * @return bool
	 */
	public function hasItem($id);
	public function getItem($id);
	public function setItem($id);
}
