# ADR-001 : Choix du bus de messages pour Streamify

## Problématique

Faire communiquer des services au retour très varié entre eux avec une faible latence.

## Contexte

L’architecture microservices de Streamify nécessite un bus de messages pour gérer la communication asynchrone entre services :

-   Événements métier
-   Logs et notifications
-   Synchronisation des données

L’objectif est de choisir la technologie la plus adaptée au contexte de Streamify.

## Options

### RabbitMQ – File de messages robuste et simple à mettre en œuvre

Robustesse et simplicité : RabbitMQ est une file de messages fiable et facile à mettre en œuvre.  
Performance : offre un bon débit et une faible latence, mais ses performances varient selon la taille des messages, le nombre de consommateurs et le type d’échange.  
Limite à grande échelle : moins efficace que Kafka pour les charges massives.  
Fiabilité : possibilité de marquer les messages comme persistants pour assurer leur sauvegarde sur disque en cas de panne.  
Coût et maintenance : logiciel open-source, avec une documentation complète, une communauté active et des options de support professionnel.

### Kafka – Plateforme d’événements hautement scalable et persistante

Scalabilité et performance : Kafka est une plateforme d’événements hautement scalable, capable de traiter des millions de messages par seconde.  
Utilisation à grande échelle : adopté par des entreprises comme Netflix pour la gestion de flux de données massifs.  
Stockage et vitesse : écrit directement sur le disque sans passer par la mémoire vive, assurant rapidité et persistance.  
Architecture distribuée : les clusters Kafka regroupent plusieurs brokers, permettant d’augmenter facilement la capacité en ajoutant de nouveaux nœuds.  
Maintenance : la gestion interne est complexe (équilibrage des données, couplage stockage-calcul). Il est conseillé d’utiliser des services managés plutôt que de l’héberger soi-même.

### NATS / JetStream – Solution légère et rapide pour la communication interne

Légèreté et rapidité : NATS est une solution de messagerie simple, rapide et à très faible latence, idéale pour la communication interne.  
Livraison des messages : par défaut, NATS ne garantit pas la livraison — les messages non récupérés sont perdus.  
Persistance optionnelle : pour assurer la durabilité des messages, il faut utiliser NATS Streaming (JetStream), qui stocke les messages sur disque mais réduit les performances.  
Scalabilité : supporte le clustering, permettant de gérer de nombreuses connexions simultanées tout en conservant une faible latence.  
Limites : la non-persistance native rend NATS moins adapté lorsque la fiabilité des messages est essentielle.

### Azure Service Bus – Solution managée cloud

Performance : Azure Service Bus offre un bon débit et une faible latence, adaptés à la majorité des échanges interservices.  
Persistance et relecture : les messages peuvent être persistés et relus via les files de secours (DLQ), garantissant une haute fiabilité.  
Complexité d’exploitation et monitoring : la configuration est plus complexe, mais le service s’intègre bien avec Azure Monitor pour le suivi.  
Résilience et scalabilité : haute disponibilité assurée, mais la scalabilité reste limitée sur le plan Standard.  
Coût et maintenance : le plan Premium apporte de meilleures performances au prix d’un coût plus élevé et d’une gestion plus exigeante.

## Conclusion

Kafka est retenu comme solution pour Streamify grâce à sa scalabilité horizontale, sa persistance native et sa faible latence, ce qui permet de gérer des volumes massifs de messages tout en assurant la relecture et la durabilité des événements. Son écosystème mature facilite le traitement temps réel et l’intégration de données.

En revanche, Kafka présente une complexité d’exploitation et un coût de maintenance plus élevés, ce qui justifie l’usage recommandé d’une solution managée pour réduire la charge opérationnelle.

## Conséquences

Le choix de Kafka offre une messagerie performante, résiliente et évolutive, adaptée à la croissance de la plateforme, au prix d’une gestion plus complexe et d’un investissement en maintenance.
