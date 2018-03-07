<?php
/**
 * ElasticSearch Observer to update records when product(s) updates
 */

namespace Leslie\Observers\Product;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Leslie\Product;

class ElasticsearchObserver
{
    /**
     * @var Client
     */
    private $elasticsearch;

    /**
     * ElasticsearchObserver constructor.
     */
    public function __construct()
    {

    }

    /**
     * Listen to the Product created / updated event
     *
     * @param Product $product
     */
    public function saved(Product $product) : void
    {
        $this->elasticsearch = ClientBuilder::create()->build();

        $product->aboveground = (isset($product->aboveground) && $product->aboveground) ? "aboveground" : "belowground";

        $this->elasticsearch->index([
            'index' => 'products',
            'type' => 'products',
            'id' => $product->id,
            'body' => $product->toArray()
        ]);
    }


    /**
     * Listen to the Product deleting event
     *
     * @param Product $product
     * @return void
     */
    public function deleted(Product $product) : void
    {
        $this->elasticsearch = ClientBuilder::create()->build();

        $this->elasticsearch->delete([
           'index' => 'products',
            'type' => 'products',
            'id' => $product->id
        ]);
    }

}