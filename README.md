Cette API REST utilise Laravel avec une architecture en 3 couches distinctes pour séparer les responsabilités entre la présentation, la logique métier et l'accès aux données.
Structure du projet

Rôles des composants
Controllers

YourController.php : Point d'entrée des requêtes frontend, validation, retour JSON

Services

UserService.php : Logique métier, orchestration des opérations

Repositories

ModelRepository.php : Accès aux données, requêtes base de données

Models

YourModel.php : Structure des tables, relations Eloquent

Providers

AppServiceProvider.php : Configuration de l'injection de dépendances

Les étapes :

1. Frontend envoie une requête HTTP
2. YourController reçoit et valide les données
3. YourController appelle UserService via son interface(UserServicesInterface)
4. UserService applique la logique métier
5. UserService appelle ModelRepository via son interface(UserRepositoryInterface)
6. ModelRepository utilise YourModel pour accéder à la BDD
7. La réponse remonte la chaîne jusqu'au frontend en JSON
