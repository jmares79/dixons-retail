<?php 

namespace App\Services;

use App\Interfaces\FetcherInterface;

class ProductService
{
    protected $fetcher;
    protected $tracking;

    public function __construct(FetcherInterface $fetcher, TrackingService $tracking)
    {
        $this->fetcher = $fetcher;
        $this->tracking = $tracking;
    }
    
    /**
     * Return the JSON representation of product data
     *
     * @param string $id
     * @return string JSON representing the data
     */
    public function detail($id)
    {
        //TODO Add to a queue for async processing, to avoid bottlenecks
        $this->tracking->track($id);

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
