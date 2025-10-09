<?php

namespace App\Application\Handlers\Queries;

use App\Application\Queries\GetUserWithAccountsQuery;
use App\Domain\Entity\UserEntity;
use App\Persistence\Interfaces\UserRepositoryInterface;
use App\Persistence\Interfaces\AccountRepositoryInterface;
use Illuminate\Support\Facades\Log;

class GetUserWithAccountsHandler
{
    private UserRepositoryInterface $userRepository;
    private AccountRepositoryInterface $accountRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        AccountRepositoryInterface $accountRepository
    ) {
        $this->userRepository = $userRepository;
        $this->accountRepository = $accountRepository;
    }

    public function handle(GetUserWithAccountsQuery $query): array
    {
        Log::info('Début de la récupération des données agrégées pour userId: ' . $query->getUserId());

        // Récupérer l'utilisateur
        $user = $this->userRepository->find($query->getUserId());
        if (!$user) {
            Log::error('Utilisateur non trouvé: ' . $query->getUserId());
            return [];
        }

        // Récupérer tous les comptes de l'utilisateur
        $accounts = $this->accountRepository->getAllAccountsByUserId($query->getUserId());

        Log::info('Données agrégées récupérées avec succès pour userId: ' . $query->getUserId() . 
                 ', nombre de comptes: ' . count($accounts));

        // Retourner les données agrégées
        return [
            'user' => [
                'nom' => $user->nom,
                'prenom' => $user->prenom,
            ],
            'accounts' => $accounts
        ];
    }
}