<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// ===== Interfaces =====
// User
use App\Persistence\Interfaces\UserRepositoryInterface;
use App\Application\Interfaces\UserServiceInterface;
use App\Application\Interfaces\CommandBusInterface;
use App\Application\Interfaces\QueryBusInterface;
// Account
use App\Persistence\Interfaces\AccountRepositoryInterface;

// ===== Services et Buses =====
use App\Application\Services\UserService;
use App\Application\Services\SimpleCommandBus;
use App\Application\Services\SimpleQueryBus;

// ===== Repositories =====
use App\Persistence\Repositories\ModelRepository; // User
use App\Persistence\Repositories\AccountRepository; // Account

// ===== Command Handlers =====
// User
use App\Application\Handlers\Commands\CreateUserCommandHandler;
use App\Application\Handlers\Commands\UpdateUserCommandHandler;
use App\Application\Handlers\Commands\DeleteUserCommandHandler;
// Account
use App\Application\Handlers\Commands\CreateAccountCommandHandler;
use App\Application\Handlers\Commands\DeleteAccountCommandHandler;

// ===== Query Handlers =====
// User
use App\Application\Handlers\Queries\GetAllUsersQueryHandler;
use App\Application\Handlers\Queries\GetUserByIdQueryHandler;
// Account
use App\Application\Handlers\Queries\GetAllAccountQueryHandler;

// ===== Commands & Queries =====
// User
use App\Application\Commands\CreateUserCommand;
use App\Application\Commands\UpdateUserCommand;
use App\Application\Commands\DeleteUserCommand;
use App\Application\Queries\GetAllUsersQuery;
use App\Application\Queries\GetUserByIdQuery;
// Account
use App\Application\Commands\CreateAccountCommand;
use App\Application\Commands\DeleteAccountCommand;
use App\Application\Queries\GetAllAccountQuery;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // ===== REPOSITORIES =====
        $this->app->bind(UserRepositoryInterface::class, ModelRepository::class);
        $this->app->bind(AccountRepositoryInterface::class, AccountRepository::class);

        // ===== BUSES =====
        $this->app->singleton(CommandBusInterface::class, SimpleCommandBus::class);
        $this->app->singleton(QueryBusInterface::class, SimpleQueryBus::class);

        // ===== HANDLERS =====
        // User Command Handlers
        $this->app->bind(CreateUserCommandHandler::class, fn($app) => new CreateUserCommandHandler($app->make(UserRepositoryInterface::class)));
        $this->app->bind(UpdateUserCommandHandler::class, fn($app) => new UpdateUserCommandHandler($app->make(UserRepositoryInterface::class)));
        $this->app->bind(DeleteUserCommandHandler::class, fn($app) => new DeleteUserCommandHandler($app->make(UserRepositoryInterface::class)));

        // User Query Handlers
        $this->app->bind(GetAllUsersQueryHandler::class, fn($app) => new GetAllUsersQueryHandler($app->make(UserRepositoryInterface::class)));
        $this->app->bind(GetUserByIdQueryHandler::class, fn($app) => new GetUserByIdQueryHandler($app->make(UserRepositoryInterface::class)));

        // Account Command Handlers
        $this->app->bind(CreateAccountCommandHandler::class, fn($app) => new CreateAccountCommandHandler($app->make(AccountRepositoryInterface::class)));
        $this->app->bind(DeleteAccountCommandHandler::class, fn($app) => new DeleteAccountCommandHandler($app->make(AccountRepositoryInterface::class)));

        // Account Query Handlers
        $this->app->bind(GetAllAccountQueryHandler::class, fn($app) => new GetAllAccountQueryHandler($app->make(AccountRepositoryInterface::class)));

        // ===== SERVICE PRINCIPAL =====
        $this->app->bind(UserServiceInterface::class, UserService::class);
    }

    public function boot(): void
    {
        $this->configureCommandBus();
        $this->configureQueryBus();
    }

    private function configureCommandBus(): void
    {
        $commandBus = $this->app->make(CommandBusInterface::class);

        // User Commands
        $commandBus->registerHandler(CreateUserCommand::class, $this->app->make(CreateUserCommandHandler::class));
        $commandBus->registerHandler(UpdateUserCommand::class, $this->app->make(UpdateUserCommandHandler::class));
        $commandBus->registerHandler(DeleteUserCommand::class, $this->app->make(DeleteUserCommandHandler::class));

        // Account Commands
        $commandBus->registerHandler(CreateAccountCommand::class, $this->app->make(CreateAccountCommandHandler::class));
        $commandBus->registerHandler(DeleteAccountCommand::class, $this->app->make(DeleteAccountCommandHandler::class));
    }

    private function configureQueryBus(): void
    {
        $queryBus = $this->app->make(QueryBusInterface::class);

        // User Queries
        $queryBus->registerHandler(GetAllUsersQuery::class, $this->app->make(GetAllUsersQueryHandler::class));
        $queryBus->registerHandler(GetUserByIdQuery::class, $this->app->make(GetUserByIdQueryHandler::class));

        // Account Queries
        $queryBus->registerHandler(GetAllAccountQuery::class, $this->app->make(GetAllAccountQueryHandler::class));
    }
}
