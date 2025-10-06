<?php

namespace App\Application\Handlers\Commands;

use App\Application\Commands\CreateAccountCommand;
use App\Persistence\Interfaces\AccountRepositoryInterface;
use App\Domain\Entity\AccountEntity;

class CreateAccountCommandHandler
{
    public function __construct(private AccountRepositoryInterface $repository) {}

    public function handle(CreateAccountCommand $command): AccountEntity
    {
        $account = new AccountEntity(null, $command->user_id, $command->name);
        return $this->repository->create($account);
    }
}
