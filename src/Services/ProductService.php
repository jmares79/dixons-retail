<?php 

namespace App\Services;

use App\Interfaces\FetcherInterface;

class ProductService
{
    protected $fetcher;

    public function __construct(FetcherInterface $fetcher)
    {
        $this->fetcher = $fetcher;
    }
    
    /**
     * Return the JSON representation of product data
     *
     * @param string $id
     * @return string JSON representing the data
     */
    public function detail($id)
    {
        return $this->fetcher->fetch($id);
    }

}
