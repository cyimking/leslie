<?php

namespace Leslie\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Leslie\Observers\Product\ElasticsearchObserver;
use Leslie\Product;
use Leslie\Repositories\Product\EloquentProduct;
use Leslie\Repositories\Product\ProductRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Product::observe(ElasticsearchObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ProductRepository::class, EloquentProduct::class);
    }
}
