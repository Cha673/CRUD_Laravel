<?php

namespace App\Application\Handlers\Queries;

use App\Application\Queries\GetAllUsersQuery;
use App\Persistence\Interfaces\UserRepositoryInterface;

class GetAllUsersQueryHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    /**
     * @return array<UserEntity>
     */
    public function handle(GetAllUsersQuery $query): array
    {
        return $this->userRepository->getAll();
    }
}