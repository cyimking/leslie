<?php

namespace Leslie\Providers;

use Illuminate\Support\ServiceProvider;
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
        //
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
