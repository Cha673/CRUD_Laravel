<?php

namespace App\Application\Handlers\Queries;

use App\Application\Queries\GetUserByIdQuery;
use App\Domain\Entity\UserEntity;
use App\Persistence\Interfaces\UserRepositoryInterface;

class GetUserByIdQueryHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function handle(GetUserByIdQuery $query): ?UserEntity
    {
        return $this->userRepository->find($query->id);
    }
}