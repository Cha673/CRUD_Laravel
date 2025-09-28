<?php

namespace App\Application\Services;

use App\Application\Interfaces\QueryBusInterface;

class SimpleQueryBus implements QueryBusInterface
{
    private array $handlers = [];

    /**
     * Enregistre un handler pour une requête donnée
     */
    public function registerHandler(string $queryClass, object $handler): void
    {
        $this->handlers[$queryClass] = $handler;
    }

    /**
     * Dispatche une requête vers son handler approprié
     */
    public function dispatch(object $query): mixed
    {
        $queryClass = get_class($query);
        
        if (!isset($this->handlers[$queryClass])) {
            throw new \InvalidArgumentException("No handler registered for query: $queryClass");
        }

        return $this->handlers[$queryClass]->handle($query);
    }
}