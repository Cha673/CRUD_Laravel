<?php

namespace App\Application\Handlers\Commands;

use App\Application\Commands\UpdateUserCommand;
use App\Domain\Entity\UserEntity;
use App\Persistence\Interfaces\UserRepositoryInterface;

class UpdateUserCommandHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function handle(UpdateUserCommand $command): ?UserEntity
    {
        $profil = $this->determinerProfil($command->email);
        
        $user = new UserEntity(
            $command->id,
            $command->nom,
            $command->prenom,
            $command->email,
            $command->telephone,
            $profil
        );

        return $this->userRepository->update($command->id, $user);
    }

    private function determinerProfil(string $email): string
    {
        return str_ends_with($email, '@company.com') ? 'Administrateur' : 'Utilisateur standard';
    }
}