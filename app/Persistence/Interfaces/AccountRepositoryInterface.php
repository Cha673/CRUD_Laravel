<?php

namespace App\Persistence\Interfaces;

use App\Domain\Entity\AccountEntity;

interface AccountRepositoryInterface
{
    public function getAll(): array;
    public function create(AccountEntity $account): AccountEntity;
    public function delete($id): bool;
    //trouver le compte correspond à un userId afin de le supprimer
    public function findByUserId(int $userId): ?AccountEntity;
}
