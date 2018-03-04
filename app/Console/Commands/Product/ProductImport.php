<?php

namespace Leslie\Console\Commands\Product;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Leslie\Product;
use Leslie\Repositories\Product\ProductRepository;

class ProductImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products from Leslie\'s API';

    /**
     * @var ProductRepository
     */
    private $products;

    /**
     * @var Client
     */
    private $client;

    /**
     * Create a new command instance.
     *
     * @param ProductRepository $products
     * @param Client $client
     */
    public function __construct(ProductRepository $products, Client $client)
    {
        parent::__construct();
        $this->products = $products;
        $this->client = $client;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
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
