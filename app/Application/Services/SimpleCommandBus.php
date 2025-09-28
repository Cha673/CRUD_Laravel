<?php

namespace App\Application\Services;

use App\Application\Interfaces\CommandBusInterface;

class SimpleCommandBus implements CommandBusInterface
{
    private array $handlers = [];

    /**
     * Enregistre un handler pour une commande donnée
     */
    public function registerHandler(string $commandClass, object $handler): void
    {
        $this->handlers[$commandClass] = $handler;
    }

    /**
     * Dispatche une commande vers son handler approprié
     */
    public function dispatch(object $command): mixed
    {
        $commandClass = get_class($command);
        
        if (!isset($this->handlers[$commandClass])) {
            throw new \InvalidArgumentException("No handler registered for command: $commandClass");
        }

        return $this->handlers[$commandClass]->handle($command);
    }
}