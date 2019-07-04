<?php

namespace App\Services;

/**
 * Mocked class for representing some type of custom cache system
 */
class CacheService implements CacheInterface
{
	public function hasItem($id)
	{
		return true;
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