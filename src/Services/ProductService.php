<?php 

namespace App\Services;

use App\Interfaces\FetcherInterface;

class ProductService
{
    protected $fetcher;
    protected $tracking;
    protected $cache;

    public function __construct(
        FetcherInterface $fetcher, 
        TrackingService $tracking,
        CacheInterface $cache
    )
    {
        $this->fetcher = $fetcher;
        $this->tracking = $tracking;
        $this->cache = $cache;
    }
    
    /**
     * Return the JSON representation of product data
     *
     * @param string $id
     * @return string JSON representing the data
     */
    public function detail($id)
    {
        $this->tracking->track($id);
        
        //TODO Add to a queue for async processing, to avoid bottlenecks
        if ($cache->hasItem($id)) {
            return $cache->getItem($id);
        }

        return $this->fetcher->fetch($id);
    }

    /**
     * Return the tracking data for a product or, in case no id is passed, for all of them
     *
     * @param string $id
     * @return array Product tracking
     */
    public function getProductsTracking($id = null)
    {
        if (!isset($id)) {
            return $this->tracking->getTrackings();
        } else {
            return $this->tracking->getById($id);
        }
    }
}
