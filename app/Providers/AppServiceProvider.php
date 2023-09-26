<?php

namespace App\Providers;

use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\StoreRepository;
use Core\Domain\Repositories\StoreRepositoryInterface;
use Core\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->bindRepositories();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    private function bindRepositories()
    {
        $this->app->singleton(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->singleton(
            StoreRepositoryInterface::class,
            StoreRepository::class,
        );
    }
}
