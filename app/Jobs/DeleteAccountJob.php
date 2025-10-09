<?php

namespace App\Jobs;

use App\Application\Commands\DeleteAccountCommand;
use App\Application\Handlers\Commands\DeleteAccountCommandHandler;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DeleteAccountJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public int $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    public function handle(DeleteAccountCommandHandler $handler, \App\Persistence\Interfaces\AccountRepositoryInterface $repo)
    {
        // Cherche le compte associé
        $account = $repo->findByUserId($this->userId);
        if ($account) {
            try {
                $handler->handle(new DeleteAccountCommand($account->id));
            } catch (\Exception $e) {
                // Annuler la suppression de l'utilisateur si le compte n'a pas été supprimé
                throw $e; 
            }
        }
    }
}
