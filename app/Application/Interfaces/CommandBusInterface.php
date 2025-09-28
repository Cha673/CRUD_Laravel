<?php

namespace App\Application\Interfaces;

interface CommandBusInterface
{
    /**
     * Dispatche une commande vers son handler approprié
     * 
     * @param object $command La commande à exécuter
     * @return mixed Le résultat de l'exécution de la commande
     * @throws \InvalidArgumentException Si aucun handler n'est trouvé
     */
    public function dispatch(object $command): mixed;
}