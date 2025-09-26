<?php

namespace App\Application\Interfaces;

interface UserServiceInterface
{
    public function getAllUsers();
    public function createUser(array $data);
    public function findUser($id);
    public function updateUser($id, array $data);
    public function deleteUser($id);
}
