<?php

namespace App\Persistence\Repositories;

use App\Domain\Entity\UserEntity;
use App\Persistence\Interfaces\UserRepositoryInterface;
use App\Models\User;

class ModelRepository implements UserRepositoryInterface
{

    // Récupère tous les utilisateurs et retourne un tableau d'Entity UserEntity
    public function getAll(): array
    {
        return (new User)->newQuery()->get()->map(function ($m) {
            return new UserEntity($m->id !== null ? (int) $m->id : null,$m->nom, $m->prenom, $m->email, $m->telephone, $m->profil);
        })->toArray();
    }

    // Crée un nouvel utilisateur à partir d'une Entity UserEntity
    public function create(UserEntity $user): UserEntity
    {
        $model = (new User)->newQuery()->create([
            'nom' => $user->nom,
            'prenom' => $user->prenom,
            'email' => $user->email,
            'telephone' => $user->telephone,
            'profil' => $user->profil,
        ]);

        return new UserEntity( $model->id !== null ? (int) $model->id : null,$model->nom, $model->prenom, $model->email, $model->telephone, $model->profil);
    }

    // Trouve un utilisateur par ID et retourne une Entity UserEntity
    public function find($id): ?UserEntity
    {
        $m = (new User)->newQuery()->where('id', $id)->first();

        return new UserEntity($m->id !== null ? (int) $m->id : null, $m->nom, $m->prenom, $m->email, $m->telephone, $m->profil);
    }

    // Met à jour un utilisateur à partir d'une Entity UserEntity
    public function update($id, UserEntity $user): ?UserEntity
    {
        $record = (new User)->newQuery()->where('id', $id)->first();
        $record->nom=$user->nom;
        $record->prenom=$user->prenom;
        $record->email=$user->email;
        $record->telephone=$user->telephone;
        $record->profil=$user->profil;
        $record->save();

        return new UserEntity($record->id !== null ? (int) $record->id : null, $record->nom, $record->prenom, $record->email, $record->telephone, $record->profil);
    }

    // Supprime un utilisateur par ID
    public function delete($id): bool
    {
        $record = (new User)->newQuery()->where('id', $id)->delete();

        return $record;
    }
}
