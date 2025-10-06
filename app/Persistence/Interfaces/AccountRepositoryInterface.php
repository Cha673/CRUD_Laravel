<?php

namespace App\Persistence\Interfaces;

use App\Domain\Entity\AccountEntity;

interface AccountRepositoryInterface
{
    public function getAll(): array;
    public function create(AccountEntity $account): AccountEntity;
    public function delete($id): bool;
    public function findByUserId(int $userId): ?AccountEntity;
}
