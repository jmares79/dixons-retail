<?php

namespace App\Services;

use App\Interfaces\FetcherInterface;
use App\Exceptions\InvalidConfigurationException;

class FetcherService implements FetcherInterface
{
    /**
     * @var RepositoryService which holds the strategy to be selected for the final fetching
     */
    protected $repository;

    public function __construct()
    {
       

        $this->repository = $this->getEnabledModel();
    }


    public function fetch($id)
    {
        return json_encode($this->repository->findById($id));
    }

    /**
     * Simulates a whole ConfigurationService to get the enabled data model
     *
     * @return CommonSearchDriver
     */
    protected function getEnabledModel()
    {
        if ($_ENV['MODEL_DEFAULT_ENABLED'] === 'true') {
            return new ElasticSearchService();
        } else {
            return new MySQLSearchService();
        }
    }
}
