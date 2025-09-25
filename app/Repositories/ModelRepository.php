<?php

namespace App\Repositories;

use App\Models\YourModel;
use App\Repositories\Interfaces\UserRepositoryInterface;

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
        $record->update($data);
        return $record;
    }

    public function delete($id)
    {
        $record = $this->model->find($id);
        if (!$record) {
            return false; // ou lancer une exception
        }
        return $record->delete(); // renvoie true si succès
    }
}