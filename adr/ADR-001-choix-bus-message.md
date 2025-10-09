# ADR-001 : Choix du bus de messages pour Streamify

## Problématique

Faire communiquer des services au retour très varié entre eux avec une faible latence.

## Contexte

L’architecture microservices nécessite un bus de messages pour gérer la communication asynchrone (événements métier, logs, notifications, synchronisation des données).

## Objectif

Choisir la technologie la plus adaptée au contexte de Streamify.

## Options

### RabbitMQ – File de messages robuste et simple à mettre en œuvre

-   **Robustesse et simplicité** : File de messages fiable et facile à mettre en œuvre.
-   **Performance** : Bon débit et faible latence, mais performances variables selon taille des messages, nombre de consommateurs et type d’échange. Débit diminue au-delà de 30 Mo/s et latence augmente.
-   **Limite à grande échelle** : Moins efficace que Kafka pour les charges massives.
-   **Fiabilité** : Messages persistants possibles pour sauvegarde sur disque.
-   **Coût et maintenance** : Open-source, documentation complète, communauté active. Options de support professionnel : ~1 999 $ pour le plan illimité (100 000 connexions simultanées, 400 Go de stockage persistant).

### Kafka – Plateforme d’événements hautement scalable et persistante

-   **Scalabilité et performance** : Traite des millions de messages par seconde, jusqu'à 2 millions avec latence p99 de 5 ms.
-   **Utilisation à grande échelle** : Adopté par Netflix pour la gestion de flux massifs. Coût approximatif : 147 $ (3 nœuds de base) + 0.27$/Gib/mois.
-   **Stockage et vitesse** : Écriture directe sur disque, rapide et persistante.
-   **Architecture distribuée** : Clusters avec plusieurs brokers, capacité augmentable en ajoutant des nœuds.
-   **Maintenance** : Gestion complexe (équilibrage des données, couplage stockage-calcul). Recommandé d’utiliser un service managé.

### NATS / JetStream – Solution légère et rapide pour la communication interne

-   **Légèreté et rapidité** : Très faible latence, idéale pour communication interne.
-   **Livraison des messages** : Par défaut, non garantie — messages non récupérés perdus.
-   **Persistance optionnelle** : Avec NATS Streaming (JetStream), messages stockés sur disque mais performances réduites.
-   **Scalabilité** : Supporte le clustering, faible latence maintenue.
-   **Limites** : Non-persistance native, max 160 000 messages par seconde. Coût : 49 $ (plan Starter) incluant 3 comptes, 100 connexions, 100 Go de données réseau et 10 Go de stockage.

### Azure Service Bus – Solution managée cloud

-   **Performance** : Bon débit et faible latence, adapté à la majorité des échanges interservices.
-   **Persistance et relecture** : Messages persistés et relus via files de secours (DLQ), haute fiabilité.
-   **Complexité d’exploitation et monitoring** : Configuration plus complexe, intégration avec Azure Monitor.
-   **Résilience et scalabilité** : Haute disponibilité, scalabilité limitée sur plan Standard.
-   **Coût et maintenance** : Plan Premium : ~700 $, meilleures performances mais gestion plus exigeante.

## Conclusion

Kafka est retenu pour Streamify grâce à :

-   Scalabilité horizontale
-   Persistance native
-   Faible latence

Cela permet de gérer des volumes massifs de messages tout en assurant la relecture et la durabilité des événements. Son écosystème mature facilite le traitement temps réel et l’intégration de données.

**Inconvénient** : Complexité d’exploitation et coût de maintenance plus élevés, justifiant l’usage recommandé d’une solution managée.

## Conséquences

Le choix de Kafka offre une messagerie performante, résiliente et évolutive, adaptée à la croissance de la plateforme, au prix d’une gestion plus complexe et d’un investissement en maintenance.
