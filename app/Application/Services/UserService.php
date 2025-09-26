<?php

namespace App\Application\Services;

use App\Application\DTO\UserDTO;
use App\Domain\Entity\UserEntity;
use App\Persistence\Interfaces\UserRepositoryInterface;
use App\Application\Interfaces\UserServiceInterface;

class UserService implements UserServiceInterface
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    // Récupère tous les utilisateurs
    public function getAllUsers(): array
    {
        return $this->userRepository->getAll();
    }

    // Crée un nouvel utilisateur
    public function createUser(UserDTO $dto): UserEntity
    {
        $profil = $this->determinerProfil($dto->email);

        $user = new UserEntity(
            null,              // Pas d'ID pour la création
            $dto->nom,
            $dto->prenom,
            $dto->email,
            $dto->telephone,
            $profil
        );

        return $this->userRepository->create($user);
    }

    // Trouve un utilisateur par ID
    public function findUser($id): ?UserEntity
    {
        return $this->userRepository->find($id);
    }

    // Met à jour un utilisateur
    public function updateUser($id, UserDTO $dto): ?UserEntity
    {
        $profil = $this->determinerProfil($dto->email);

        $user = new UserEntity(
            (int)$id,       
            $dto->nom,
            $dto->prenom,
            $dto->email,
            $dto->telephone,
            $profil
        );

        return $this->userRepository->update($id, $user);
    }

    // Supprime un utilisateur
    public function deleteUser($id): bool
    {
        return $this->userRepository->delete($id);
    }

    // Détermine le profil en fonction du mail
    private function determinerProfil(string $email): string
    {
        return str_ends_with($email, '@company.com') ? 'Administrateur' : 'Utilisateur standard';
    }
}
