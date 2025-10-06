<?php

namespace App\Application\Handlers\Commands;

use App\Application\Commands\DeleteAccountCommand;
use App\Persistence\Interfaces\AccountRepositoryInterface;

class DeleteAccountCommandHandler
{
    public function __construct(private AccountRepositoryInterface $repository) {}

    public function handle(DeleteAccountCommand $command): bool
    {
        return $this->repository->delete($command->id);
    }
}
