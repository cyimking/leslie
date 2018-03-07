<?php

namespace Leslie\Console\Commands\Product;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Leslie\Jobs\ProductImport;
use Leslie\Product;
use Leslie\Repositories\Product\ProductRepository;

class ImportCommand extends Command
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
     * Create a new command instance.
     *
     * @param ProductRepository $products
     */
    public function __construct(ProductRepository $products)
    {
        parent::__construct();
        $this->products = $products;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ProductImport::dispatch($this->products);
    }
}
