<?php

namespace Leslie\Console\Commands\Product;

use Illuminate\Console\Command;
use Leslie\Jobs\ProductIndex;

class IndexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:index-elasticsearch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexes products to elasticsearch';


    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ProductIndex::dispatch();
    }
}
