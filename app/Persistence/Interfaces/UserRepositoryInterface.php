<?php

namespace App\Persistence\Interfaces;

use App\Domain\Entity\UserEntity;

interface UserRepositoryInterface
{
    // Récupérer tous les utilisateurs
    public function getAll(): array;

    // Récupérer un utilisateur par son ID
    public function find($id): ?UserEntity;

    // Créer un nouvel utilisateur à partir d'une Entity UserEntity
    public function create(UserEntity $user): UserEntity;

    // Mettre à jour un utilisateur avec une Entity UserEntity
    public function update($id, UserEntity $user): ?UserEntity;

    // Supprimer un utilisateur
    public function delete($id): bool;
}
