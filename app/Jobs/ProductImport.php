<?php

namespace Leslie\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Leslie\Product;
use Leslie\Repositories\Product\ProductRepository;

class ProductImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 300;

    /**
     * @var ProductRepository
     */
    private $products;

    /**
     * @var Client
     */
    private $client;

    /**
     * Create a new job instance.
     *
     * @param ProductRepository $products
     */
    public function __construct(ProductRepository $products)
    {
        $this->products = $products;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->client = new Client();   // Laravel will try to serialize the class properties

        // Retrieve existing ids from DB
        $existing_ids = Product::all()->pluck('product_id')->all();

        // API call to retrieve IDS from Leslie
        $response = $this->client->request('GET', 'http://www.poolsupplyworld.com/api.cfm', [
            'headers' => [
                'authkey' => 'GP4OB7SA7LVUC3M-lamar'
            ]
        ]);

        // Convert IDS to array format
        $lids = json_decode((string) $response->getBody());

        // Create or Update products
        foreach ($lids as $id) {
            $update = \in_array($id, $existing_ids, true);

            $product = $this->getProduct($id);

            if($response->getStatusCode() === 200) {
                if (!$update) {
                    $this->products->create($product);
                } else {
                    $this->products->update($id, $product);
                }
                // Testing Only....
                $string = 'Product ID: ' . $id;
                $string .= ($update) ? ' - UPDATE' : ' - CREATE';
            } else {
                $string = 'Product ID: ' . $id;
                $string .= ' - Error Code: ' . $response->getStatusCode();
            }

            echo $string . PHP_EOL;
        }
    }

    /**
     * Helper function to return the product as an array
     *
     * @param $id
     * @return array
     */
    private function getProduct($id) : array
    {
        $response = $this->client->request('GET', 'http://www.poolsupplyworld.com/api.cfm?productid=' . $id, [
            'headers' => [
                'authkey' => 'GP4OB7SA7LVUC3M-lamar'
            ]
        ]);
        $product = json_decode((string) $response->getBody(), true);
        $product['product_id'] = $product['id'];
        unset($product['id']);

        return $product;
    }
}
