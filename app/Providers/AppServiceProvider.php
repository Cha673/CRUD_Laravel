<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Persistence\Interfaces\UserRepositoryInterface;
use App\Application\Services\UserService;
use App\Application\Interfaces\UserServiceInterface;
use App\Persistence\Repositories\ModelRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // LIAISON : Interface → Repository
        $this->app->bind(
            \App\Application\Interfaces\UserServiceInterface::class,
            \App\Application\Services\UserService::class
        );
        
        $this->app->bind(
            \App\Persistence\Interfaces\UserRepositoryInterface::class,
            \App\Persistence\Repositories\ModelRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}