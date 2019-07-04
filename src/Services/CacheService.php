<?php

namespace App\Services;

use App\Interfaces\CacheInterface;

/**
 * Mocked class for representing some type of custom cache system
 */
class CacheService implements CacheInterface
{
	public function hasItem($id)
	{
		return false;
	}
	
	public function getItem($id)
	{
		return [$id];
	}
	
	public function setItem($id)
	{
		return true;
	}
}