<?php

namespace App\Providers;

use App\Domain\Repositories\ProductRepository;
use App\Repositories\EloquentProductRepository;
use Illuminate\Support\ServiceProvider;

class BindingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->repositories();
    }

    private function repositories(): void
    {
        $this->app->bind(ProductRepository::class, EloquentProductRepository::class);
    }
}
