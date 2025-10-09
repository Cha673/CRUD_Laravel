<?php

namespace App\Jobs;

use App\Application\Commands\CreateAccountCommand;
use App\Application\Handlers\Commands\CreateAccountCommandHandler;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateAccountJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public int $userId;
    public string $name;

    public function __construct(int $userId, string $name)
    {
        $this->userId = $userId;
        $this->name = $name;
    }

    public function handle(CreateAccountCommandHandler $handler)
    {
        try {
            // Crée le compte associé
            $handler->handle(new CreateAccountCommand($this->userId, $this->name));
        } catch (\Exception $e) {
            // Si la création échoue, supprimer l'utilisateur
            dispatch(new DeleteUserJob($this->userId));
            throw $e; // on relance pour que Laravel log l'erreur
        }
    }
}
