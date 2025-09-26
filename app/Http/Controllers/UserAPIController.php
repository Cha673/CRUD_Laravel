<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Interfaces\UserServiceInterface;

class UserApiController extends Controller
{
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    // Liste tous les utilisateurs
    public function index()
    {
        $users = $this->userService->getAllUsers();
        return response()->json($users);
    }

    // Affiche un utilisateur par ID
    public function show($id)
    {
        $user = $this->userService->findUser($id);
        if (!$user) {
            return response()->json(['error' => 'Utilisateur introuvable'], 404);
        }
        return response()->json($user);
    }

    // Créer un nouvel utilisateur
    public function store(Request $request)
    {
        $user = $this->userService->createUser($request->all());
        return response()->json($user, 201);
    }

    // Mettre à jour un utilisateur
    public function update(Request $request, $id)
    {
        $user = $this->userService->updateUser($id, $request->all());
        if (!$user) {
            return response()->json(['error' => 'Impossible de mettre à jour l\'utilisateur'], 404);
        }
        return response()->json($user);
    }

    // Supprimer un utilisateur
    public function destroy($id)
    {
        $deleted = $this->userService->deleteUser($id);
        if (!$deleted) {
            return response()->json(['error' => 'Impossible de supprimer l\'utilisateur'], 404);
        }
        return response()->json(['message' => 'Utilisateur supprimé avec succès']);
    }
}
