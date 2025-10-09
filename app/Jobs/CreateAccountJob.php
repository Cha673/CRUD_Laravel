<?php

namespace App\Jobs;

use App\Application\Commands\CreateAccountCommand;
use App\Application\Handlers\Commands\CreateAccountCommandHandler;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class CreateAccountJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public int $userId;
    public string $name;

    public function __construct(int $userId, string $name)
    {
        $this->userId = $userId;
        $this->name = $name;
        Log::info('CreateAccountJob construit pour userId: ' . $userId);
    }

    public function handle(CreateAccountCommandHandler $handler)
    {
        Log::info('Début de CreateAccountJob->handle pour userId: ' . $this->userId);
        
        try {
            Log::info('Tentative de création du compte pour userId: ' . $this->userId);
            // Crée le compte associé
            $handler->handle(new CreateAccountCommand($this->userId, $this->name));
            Log::info('Compte créé avec succès pour userId: ' . $this->userId);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création du compte: ' . $e->getMessage());
            // Si la création échoue, supprimer l'utilisateur
            Log::info('Tentative de suppression de l\'utilisateur: ' . $this->userId);
            dispatch(new DeleteUserJob($this->userId));
            throw $e; // on relance pour que Laravel log l'erreur
        }
    }
}
