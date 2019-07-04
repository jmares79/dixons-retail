<?php

use PHPUnit\Framework\TestCase;

use App\Services\ProductService;
use App\Services\TrackingService;
use App\Services\CacheService;
use App\Services\FetcherService;

class ProductServiceTest extends TestCase
{
    protected $product;

    protected $mockedFetcher;
    protected $mockedTracker;
    protected $mockedCache;

    public function setUp()
    {
        $this->mockedFetcher = $this->createMock(FetcherService::class);
        $this->mockedTracker = $this->createMock(TrackingService::class);
        $this->mockedCache = $this->createMock(CacheService::class);

        $this->product = new ProductService(
            $this->mockedFetcher, 
            $this->mockedTracker, 
            $this->mockedCache
        );
    }

    /**
     * @dataProvider inputProvider
     */
    public function testDetail($productId, $fetchedData, $expected)
    {
        $this->mockedFetcher->method('fetch')->willReturn($fetchedData);
        $this->mockedCache->method('hasItem')->willReturn(false);

        $actual = $this->product->detail($productId);
        $decoded = json_decode($actual, true);

        $this->assertArrayHasKey($expected[0], $decoded);
        $this->assertArrayHasKey($expected[1], $decoded['_source']);
        $this->assertArrayHasKey($expected[2], $decoded['_source']);
        $this->assertArrayHasKey($expected[3], $decoded['_source']);
    }

    /**
     * Test provider for testing the product service.
     */
    public function inputProvider()
    {
        $id = 6;

        $expectedKeys = [
            '_source',
            'type',
            'id',
            'product',
        ];

        $fetchedData = [
            '_source' => [
                'type' => 'ElasticSearch',
                'id' => $id,
                'product' => 'fakeProduct'
            ]
        ];

        return array(
            array($id, json_encode($fetchedData), $expectedKeys),
        );
    }
}