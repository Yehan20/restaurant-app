<?php

namespace App\Providers;

use App\Repositories\Eloquent\ConcessionRepository;
use App\Repositories\Eloquent\OrderRepository;
use App\Repositories\Interfaces\ConcessionRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Eloquent\KitchenRepository;
use App\Repositories\Interfaces\KitchenRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
       
        // Bind Interface to Repository
        $this->app->bind(ConcessionRepositoryInterface::class, ConcessionRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(KitchenRepositoryInterface::class, KitchenRepository::class);
    } 

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
