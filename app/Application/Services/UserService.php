<?php

namespace App\Application\Services;

use App\Application\DTO\UserDTO;
use App\Application\Interfaces\UserServiceInterface;
use App\Application\Interfaces\CommandBusInterface;
use App\Application\Interfaces\QueryBusInterface;
use App\Application\Commands\CreateUserCommand;
use App\Application\Commands\UpdateUserCommand;
use App\Application\Commands\DeleteUserCommand;
use App\Application\Queries\GetAllUsersQuery;
use App\Application\Queries\GetUserByIdQuery;
use App\Application\Queries\GetUserWithAccountsQuery;
use App\Domain\Entity\UserEntity;
use App\Jobs\CreateAccountJob;
use App\Jobs\DeleteAccountJob;
use App\Jobs\DeleteUserJob;

class UserService implements UserServiceInterface
{
    private CommandBusInterface $commandBus;
    private QueryBusInterface $queryBus;

    public function __construct(
        CommandBusInterface $commandBus,
        QueryBusInterface $queryBus
    ) {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    public function getAllUsers(): array
    {
        return $this->queryBus->dispatch(new GetAllUsersQuery());
    }

    public function createUser(UserDTO $dto): UserEntity
    {
        // Création de l'utilisateur
        $user = $this->commandBus->dispatch(
            new CreateUserCommand($dto->nom, $dto->prenom, $dto->email, $dto->telephone)
        );

        // Création du compte via Job (RabbitMQ)
        $name = $user->nom . ' ' . $user->prenom;
        CreateAccountJob::dispatch($user->id, $name);

        return $user;
    }

    public function findUser(int $id): ?UserEntity
    {
        return $this->queryBus->dispatch(new GetUserByIdQuery($id));
    }

    public function updateUser(int $id, UserDTO $dto): ?UserEntity
    {
        return $this->commandBus->dispatch(
            new UpdateUserCommand(
                $id,
                $dto->nom,
                $dto->prenom,
                $dto->email,
                $dto->telephone
            )
        );
    }

    public function deleteUser(int $id): bool
    {
        // Supprime le compte associé via Job
        DeleteAccountJob::dispatch($id);

        // Supprime l'utilisateur
        return $this->commandBus->dispatch(new DeleteUserCommand($id));
    }

    public function getUserWithAccounts(int $userId): array
    {
        return $this->queryBus->dispatch(new GetUserWithAccountsQuery($userId));
    }
}
