<?php

namespace App\Persistence\Interfaces;

interface UserRepositoryInterface
{
    // Récupérer tous les utilisateurs
    public function getAll();

    // Récupérer un utilisateur par son ID
    public function find($id);

    // Créer un nouvel utilisateur
    public function create(array $data);

    // Mettre à jour un utilisateur
    public function update($id, array $data);

    // Supprimer un utilisateur
    public function delete($id);
}