<?php

namespace Leslie\Jobs;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Leslie\Product;

class ProductIndex implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 300;

    /**
     * @var Client
     */
    private $elasticsearch;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //TODO - Bind Client class to provider
        $this->elasticsearch = ClientBuilder::create()->build();

        echo 'Indexing all products...' . PHP_EOL;

        foreach ((new Product)->cursor() as $product) {
            $this->elasticsearch->index([
                'index' => 'products',
                'type' => 'products',
                'id' => $product->id,
                'body' => $product->toArray()
            ]);
        }

        echo 'Indexing complete. Have a nice day!' .  PHP_EOL;
    }
}
