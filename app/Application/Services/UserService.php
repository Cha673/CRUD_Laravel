<?php

namespace App\Application\Services;

use App\Persistence\Interfaces\UserRepositoryInterface;
use App\Application\Interfaces\UserServiceInterface;

class UserService implements UserServiceInterface
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers()
    {
        return $this->userRepository->getAll();
    }

    public function createUser(array $data)
    {
        $data['profil'] = $this->determinerProfil($data['email']);
        return $this->userRepository->create($data);
    }

    public function findUser($id)
    {
        return $this->userRepository->find($id);
    }

    public function updateUser($id, array $data)
    {
        if (isset($data['email'])) {
            $data['profil'] = $this->determinerProfil($data['email']);
        }
        return $this->userRepository->update($id, $data);
    }

    public function deleteUser($id)
    {
        return $this->userRepository->delete($id);
    }

    private function determinerProfil($email)
    {
        return str_ends_with($email, '@company.com')
            ? 'Administrateur'
            : 'Utilisateur standard';
    }
}
