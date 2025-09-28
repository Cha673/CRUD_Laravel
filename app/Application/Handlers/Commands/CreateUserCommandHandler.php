<?php

namespace App\Application\Handlers\Commands;

use App\Application\Commands\CreateUserCommand;
use App\Domain\Entity\UserEntity;
use App\Persistence\Interfaces\UserRepositoryInterface;

class CreateUserCommandHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function handle(CreateUserCommand $command): UserEntity
    {
        $profil = $this->determinerProfil($command->email);
        
        $user = new UserEntity(
            null,              // Pas d'ID pour la création
            $command->nom,
            $command->prenom,
            $command->email,
            $command->telephone,
            $profil
        );

        return $this->userRepository->create($user);
    }

    private function determinerProfil(string $email): string
    {
        return str_ends_with($email, '@company.com') ? 'Administrateur' : 'Utilisateur standard';
    }
}