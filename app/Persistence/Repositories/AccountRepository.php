<?php

namespace App\Persistence\Repositories;

use App\Domain\Entity\AccountEntity;
use App\Persistence\Interfaces\AccountRepositoryInterface;
use App\Models\Account;

class AccountRepository implements AccountRepositoryInterface
{
    public function getAll(): array
    {
        return (new Account)->newQuery()->get()->map(function ($m) {
            return new AccountEntity(
                $m->id !== null ? (int) $m->id : null,
                (int) $m->user_id,
                $m->name
            );
        })->toArray();
    }

    // Crée un nouveau compte à partir d'une AccountEntity
    public function create(AccountEntity $account): AccountEntity
    {
        $model = (new Account)->newQuery()->create([
            'user_id' => $account->user_id,
            'name' => $account->name,
        ]);

        return new AccountEntity(
            $model->id !== null ? (int) $model->id : null,
            (int) $model->user_id,
            $model->name
        );
    }

    // Supprime un compte par ID
    public function delete($id): bool
    {
        $record = (new Account)->newQuery()->where('id', $id)->delete();

        return (bool) $record;
    }

    // Récupérer tous les comptes d'un utilisateur
    public function getAllAccountsByUserId(int $userId): array
    {
        return (new Account)->newQuery()
            ->where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($m) {
                return new AccountEntity(
                    $m->id !== null ? (int) $m->id : null,
                    (int) $m->user_id,
                    $m->name
                );
            })
            ->toArray();
    }

    //trouver un compte en fonction de l'userId
    public function findByUserId(int $userId): ?AccountEntity
    {
        // Récupérer tous les comptes pour cet utilisateur
        $accounts = (new Account)->newQuery()
            ->where('user_id', $userId)
            ->orderBy('id', 'desc')  // Pour avoir le compte le plus récent
            ->get();
            
        // Retourner le premier compte trouvé
        if ($accounts->isEmpty()) {
            return null;
        }

        $m = $accounts->first();
        return new AccountEntity(
            $m->id !== null ? (int) $m->id : null,
            (int) $m->user_id,
            $m->name
        );
    }
}
