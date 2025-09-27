Cette API suit les principes de l'architecture hexagonale avec 5 couches distinctes pour garantir une séparation claire des responsabilités et une haute testabilité.

Rôles des composants
Presentation

YourController.php : Point d'entrée HTTP, gestion des requêtes/réponses

Application

UserService.php : logique métier
UserDTO.php : Objets de transfert de données
UserServiceInterface.php : Interface

Domain

UserEntity.php : Logique métier pure, règles business

Persistence

ModelRepository.php : Accès aux données
UserRepositoryInterface.php : Contrats de persistance

Models

User.php : Structure des entités métier

Principe de dépendance

Presentation dépend de Application
Application dépend de Domain
Persistence dépend de Domain
Domain ne dépend de rien (cœur métier isolé)

Exemple de flux

Frontend envoie requête HTTP
YourController (Presentation) reçoit et valide
YourController appelle UserService (Application)
UserService utilise UserEntity (Domain) pour la logique métier
UserService appelle ModelRepository (Persistence) via interface
ModelRepository utilise User.php (Models) pour la BDD
Les données remontent vers le frontend via DTO
