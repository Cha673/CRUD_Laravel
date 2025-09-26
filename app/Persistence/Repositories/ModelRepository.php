<?php

namespace App\Persistence\Repositories;

use App\Domain\Entities\YourModel;
use App\Persistence\Interfaces\UserRepositoryInterface;

class ModelRepository implements UserRepositoryInterface
{
    protected $model;

    public function __construct()
    {
        $this->model = new YourModel();
    }

    public function getAll()
    {
        // Récupère tous les utilisateurs de la base de données
        return $this->model->all();
    }

    public function create(array $data)
    {
        // Crée un nouvel utilisateur avec les données fournies
        return $this->model->create($data);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function update($id, array $data)
    {
        $record = $this->model->find($id);
        if (!$record) {
            return null; // ou lancer une exception si tu préfères
        }
        //si l'email change, remettre à jour le statut du profil
        if (isset($data['email']) && $data['email'] !== $record->email) {
            $data['profil'] = str_ends_with($data['email'], '@company.com') 
                ? 'Administrateur' 
                : 'Utilisateur standard';
        }

        $record->update($data);
        return $record;
    }

    public function delete($id)
    {
        $record = $this->model->find($id);
        if (!$record) {
            return false; 
        }
        return $record->delete(); // renvoie true si succès
    }
}