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
            UserRepositoryInterface::class,    // ← L'interface demandée
            ModelRepository::class             // ← Le repository concret à donner
        );
        $this->app->bind(UserServiceInterface::class, UserService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}