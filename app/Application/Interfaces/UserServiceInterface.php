<?php

namespace App\Application\Interfaces;

use App\Application\DTO\UserDTO;
use App\Domain\Entity\UserEntity;

interface UserServiceInterface
{
    /**
     * Récupère tous les utilisateurs
     * @return array<UserEntity>
     */
    public function getAllUsers(): array;

    public function createUser(UserDTO $dto): UserEntity;

    public function findUser(int $id): ?UserEntity;

    public function updateUser(int $id, UserDTO $dto): ?UserEntity;

    public function deleteUser(int $id): bool;

    /**
     * Récupère un utilisateur avec ses comptes associés
     * @param int $userId
     * @return array
     */
    public function getUserWithAccounts(int $userId): array;
}