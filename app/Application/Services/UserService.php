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
use App\Application\Commands\CreateAccountCommand;
use App\Application\Commands\DeleteAccountCommand;
use App\Application\Handlers\Commands\CreateAccountCommandHandler;
use App\Application\Handlers\Commands\DeleteAccountCommandHandler;
use App\Persistence\Interfaces\AccountRepositoryInterface;

class UserService implements UserServiceInterface
{
    private CommandBusInterface $commandBus;
    private QueryBusInterface $queryBus;
    private AccountRepositoryInterface $accountRepository;
    private CreateAccountCommandHandler $createAccountHandler;
    private DeleteAccountCommandHandler $deleteAccountHandler;

    public function __construct(
        CommandBusInterface $commandBus,
        QueryBusInterface $queryBus,
        AccountRepositoryInterface $accountRepository,
        CreateAccountCommandHandler $createAccountHandler,
        DeleteAccountCommandHandler $deleteAccountHandler
    ) {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
        $this->accountRepository = $accountRepository;
        $this->createAccountHandler = $createAccountHandler;
        $this->deleteAccountHandler = $deleteAccountHandler;
    }

    public function getAllUsers(): array
    {
        return $this->queryBus->dispatch(new GetAllUsersQuery());
    }

    public function createUser(UserDTO $dto): UserEntity
    {
        // Création de l'utilisateur
        $user = $this->commandBus->dispatch(
            new CreateUserCommand(
                $dto->nom,
                $dto->prenom,
                $dto->email,
                $dto->telephone
            )
        );

        // Création automatique du compte associé
        $name = $user->nom . ' ' . $user->prenom;
        $this->createAccountHandler->handle(
            new CreateAccountCommand($user->id, $name)
        );

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
        // Supprimer le compte associé si existant
        $account = $this->accountRepository->findByUserId($id);
        if ($account) {
            $this->deleteAccountHandler->handle(new DeleteAccountCommand($account->id));
        }

        // Supprimer l'utilisateur
        return $this->commandBus->dispatch(new DeleteUserCommand($id));
    }
}
