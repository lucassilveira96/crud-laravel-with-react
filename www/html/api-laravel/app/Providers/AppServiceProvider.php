<?php

namespace App\Providers;

use GuzzleHttp\Handler\Proxy;
use Illuminate\Support\ServiceProvider;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Services\Product\ProductService;
use App\Repositories\Product\ProductRepository;
use App\Services\ProductCategory\ProductCategoryService;
use App\Repositories\ProductCategory\ProductCategoryRepository;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Product::class, function ($app) {
            return new Product();
        });

        $this->app->bind(ProductService::class, function ($app) {
            return new ProductService(new ProductRepository(new Product()));
        });

        $this->app->bind(ProductCategory::class, function ($app) {
            return new ProductCategory();
        });

        $this->app->bind(ProductCategoryService::class, function ($app) {
            return new ProductCategoryService(new ProductCategoryRepository(new ProductCategory()));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
