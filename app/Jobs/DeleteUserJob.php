<?php

namespace App\Jobs;

use App\Application\Commands\DeleteUserCommand;
use App\Application\Handlers\Commands\DeleteUserCommandHandler;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DeleteUserJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public int $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    public function handle(DeleteUserCommandHandler $handler)
    {
        $handler->handle(new DeleteUserCommand($this->userId));
    }
}
