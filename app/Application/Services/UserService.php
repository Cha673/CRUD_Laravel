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
use App\Domain\Entity\UserEntity;

class UserService implements UserServiceInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus
    ) {}


    public function getAllUsers(): array
    {
        return $this->queryBus->dispatch(new GetAllUsersQuery());
    }


    public function createUser(UserDTO $dto): UserEntity
    {
        return $this->commandBus->dispatch(
            new CreateUserCommand(
                $dto->nom,
                $dto->prenom,
                $dto->email,
                $dto->telephone
            )
        );
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
        return $this->commandBus->dispatch(new DeleteUserCommand($id));
    }
}