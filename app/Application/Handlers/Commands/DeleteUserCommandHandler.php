<?php

namespace App\Application\Handlers\Commands;

use App\Application\Commands\DeleteUserCommand;
use App\Persistence\Interfaces\UserRepositoryInterface;

class DeleteUserCommandHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function handle(DeleteUserCommand $command): bool
    {
        return $this->userRepository->delete($command->id);
    }
}