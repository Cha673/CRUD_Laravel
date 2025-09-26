<?php

namespace App\Application\Interfaces;

use App\Application\DTO\UserDTO;
use App\Domain\Entity\UserEntity;

interface UserServiceInterface
{
    public function getAllUsers(): array;

    public function createUser(UserDTO $dto):  UserEntity;

    public function findUser($id): ?UserEntity;

    public function updateUser($id, UserDTO $dto): ?UserEntity;

    public function deleteUser($id): bool;
}
