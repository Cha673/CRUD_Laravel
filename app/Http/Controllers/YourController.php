<?php
namespace App\Http\Controllers;

use App\Services\Interfaces\UserServiceInterface;  
use Illuminate\Http\Request;

class YourController extends Controller
{
    protected $userService;  

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    // Afficher tous les utilisateurs
    public function index()
    {
        $users = $this->userService->getAllUsers();  //  Appel du Service
        return view('users.index', compact('users'));
    }

    // Afficher le formulaire de création
    public function create()
    {
        return view('users.create');
    }

    // Créer un nouvel utilisateur
    public function add(Request $request)
    {
        try {
            $request->validate([
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'email' => 'required|email',
                'telephone' => 'required|string|max:20'
            ]);

            $newUser = $this->userService->createUser($request->all());
            
            return redirect()->route('users.index')
                           ->with('success', 'Utilisateur créé avec le profil : ' . $newUser->profil);
                           
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Erreur : ' . $e->getMessage());
        }
    }

    // Afficher le formulaire d'édition
    public function edit($id)
    {
        try {
            $user = $this->userService->findUser($id);  //  Appel du Service
            
            if (!$user) {
                return redirect()->route('users.index')->with('error', 'Utilisateur introuvable');
            }
            
            return view('users.edit', compact('user'));
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'Erreur : ' . $e->getMessage());
        }
    }

    // Modifier un utilisateur
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'email' => 'required|email',
                'telephone' => 'required|string|max:20'
            ]);

            $updatedUser = $this->userService->updateUser($id, $request->all());
            
            if (!$updatedUser) {
                return redirect()->route('users.index')->with('error', 'Impossible de mettre à jour l\'utilisateur');
            }
            
            return redirect()->route('users.index')
                           ->with('success', 'Utilisateur mis à jour. Profil : ' . $updatedUser->profil);
                           
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Erreur : ' . $e->getMessage());
        }
    }

    // Supprimer un utilisateur
    public function destroy($id)
    {
        try {
            $deleted = $this->userService->deleteUser($id);  
            
            if (!$deleted) {
                return redirect()->route('users.index')->with('error', 'Impossible de supprimer l\'utilisateur');
            }
            
            return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'Erreur : ' . $e->getMessage());
        }
    }
}