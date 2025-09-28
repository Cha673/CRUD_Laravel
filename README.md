Ce projet utilise le pattern CQRS (Command Query Responsibility Segregation) pour séparer les opérations d'écriture (Commands) des opérations de lecture (Queries).
Structure
Commands : Intentions de modification (Create, Update, Delete)

CreateUserCommand, UpdateUserCommand, DeleteUserCommand

Queries : Demandes de lecture (Get, Find, List)

GetAllUsersQuery, GetUserByIdQuery

Handlers : Logique métier spécifique à chaque opération

Un handler par command/query dans les dossiers Commands/ et Queries/

Buses : Dispatchers qui lient les messages aux handlers

CommandBus pour les écritures, QueryBus pour les lectures

UserService : Interface inchangée qui utilise les buses en interne
Fonctionnement
Écriture : Contrôleur → UserService → CommandBus → CommandHandler → Repository
Lecture : Contrôleur → UserService → QueryBus → QueryHandler → Repository
Le UserService reste identique pour les contrôleurs mais utilise maintenant CQRS en arrière-plan.
Avantages
Séparation claire : Lectures et écritures complètement séparées
Testabilité : Chaque handler testable individuellement
Évolutivité : Nouvelles fonctionnalités = nouveau message + handler
Maintenabilité : Logique organisée et facile à localiser
Performance : Optimisations spécifiques possibles pour lectures/écritures
Configuration Laravel
Tout est configuré dans AppServiceProvider :

Enregistrement des buses comme singletons
Liaison des handlers avec injection de dépendances
Configuration automatique via boot()

Migration
Aucun changement nécessaire dans les contrôleurs existants. L'interface UserServiceInterface est préservée. La logique métier (profil automatique selon l'email) est maintenue.
Logique métier

Email @company.com → Profil "Administrateur"
Autres emails → Profil "Utilisateur standard"

Cette architecture offre une séparation claire des responsabilités tout en gardant une utilisation simple pour les développeurs.
