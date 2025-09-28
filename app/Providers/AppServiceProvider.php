<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Interfaces
use App\Persistence\Interfaces\UserRepositoryInterface;
use App\Application\Interfaces\UserServiceInterface;
use App\Application\Interfaces\CommandBusInterface;
use App\Application\Interfaces\QueryBusInterface;

// Services et Buses
use App\Application\Services\UserService;
use App\Application\Services\SimpleCommandBus;
use App\Application\Services\SimpleQueryBus;
use App\Persistence\Repositories\ModelRepository;

// Command Handlers
use App\Application\Handlers\Commands\CreateUserCommandHandler;
use App\Application\Handlers\Commands\UpdateUserCommandHandler;
use App\Application\Handlers\Commands\DeleteUserCommandHandler;

// Query Handlers
use App\Application\Handlers\Queries\GetAllUsersQueryHandler;
use App\Application\Handlers\Queries\GetUserByIdQueryHandler;

// Commands & Queries
use App\Application\Commands\CreateUserCommand;
use App\Application\Commands\UpdateUserCommand;
use App\Application\Commands\DeleteUserCommand;
use App\Application\Queries\GetAllUsersQuery;
use App\Application\Queries\GetUserByIdQuery;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // ===== REPOSITORIES =====
        $this->app->bind(
            UserRepositoryInterface::class,
            ModelRepository::class
        );

        // ===== BUSES =====
        $this->app->singleton(CommandBusInterface::class, SimpleCommandBus::class);
        $this->app->singleton(QueryBusInterface::class, SimpleQueryBus::class);

        // ===== HANDLERS =====
        // Command Handlers
        $this->app->bind(CreateUserCommandHandler::class, function ($app) {
            return new CreateUserCommandHandler($app->make(UserRepositoryInterface::class));
        });

        $this->app->bind(UpdateUserCommandHandler::class, function ($app) {
            return new UpdateUserCommandHandler($app->make(UserRepositoryInterface::class));
        });

        $this->app->bind(DeleteUserCommandHandler::class, function ($app) {
            return new DeleteUserCommandHandler($app->make(UserRepositoryInterface::class));
        });

        // Query Handlers
        $this->app->bind(GetAllUsersQueryHandler::class, function ($app) {
            return new GetAllUsersQueryHandler($app->make(UserRepositoryInterface::class));
        });

        $this->app->bind(GetUserByIdQueryHandler::class, function ($app) {
            return new GetUserByIdQueryHandler($app->make(UserRepositoryInterface::class));
        });

        // ===== SERVICE PRINCIPAL =====
        $this->app->bind(
            UserServiceInterface::class,
            UserService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configuration des handlers dans les buses après que tous les services soient enregistrés
        $this->configureCommandBus();
        $this->configureQueryBus();
    }

    /**
     * Configure le CommandBus avec ses handlers
     */
    private function configureCommandBus(): void
    {
        $commandBus = $this->app->make(CommandBusInterface::class);

        // Enregistrement des Command Handlers
        $commandBus->registerHandler(
            CreateUserCommand::class,
            $this->app->make(CreateUserCommandHandler::class)
        );

        $commandBus->registerHandler(
            UpdateUserCommand::class,
            $this->app->make(UpdateUserCommandHandler::class)
        );

        $commandBus->registerHandler(
            DeleteUserCommand::class,
            $this->app->make(DeleteUserCommandHandler::class)
        );
    }

    /**
     * Configure le QueryBus avec ses handlers
     */
    private function configureQueryBus(): void
    {
        $queryBus = $this->app->make(QueryBusInterface::class);

        // Enregistrement des Query Handlers
        $queryBus->registerHandler(
            GetAllUsersQuery::class,
            $this->app->make(GetAllUsersQueryHandler::class)
        );

        $queryBus->registerHandler(
            GetUserByIdQuery::class,
            $this->app->make(GetUserByIdQueryHandler::class)
        );
    }
}