<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\{ConcessionRepositoryInterface, OrderRepositoryInterface};
use App\Repositories\Eloquent\{ConcessionRepository, OrderRepository};

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        // $this->app->bind(ConcessionRepositoryInterface::class, ConcessionRepository::class);
        // $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
    }

    public function boot()
    {
        //
    }
}
