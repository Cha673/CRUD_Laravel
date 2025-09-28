<?php

namespace App\Application\Interfaces;

interface QueryBusInterface
{
    /**
     * Dispatche une requête vers son handler approprié
     * 
     * @param object $query La requête à exécuter
     * @return mixed Le résultat de l'exécution de la requête
     * @throws \InvalidArgumentException Si aucun handler n'est trouvé
     */
    public function dispatch(object $query): mixed;
}