<?php

namespace App\Repositories;

class ModelRepository
{
    protected $model;

    public function __construct()
    {
        // Vous pourrez initialiser votre modèle ici
    }

    public function getAll()
    {
        // Pour récupérer tous les éléments
    }

    public function find($id)
    {
        // Pour trouver un élément par son ID
    }

    public function create($data)
    {
        // Pour créer un nouvel élément
    }

    public function update($id, $data)
    {
        // Pour mettre à jour un élément
    }

    public function delete($id)
    {
        // Pour supprimer un élément
    }
}