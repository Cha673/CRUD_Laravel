<?php

namespace App\Http\Controllers;

use App\Repositories\ModelRepository;
use Illuminate\Http\Request;

class YourController extends Controller
{
    protected $repository;

    public function __construct(ModelRepository $repository)
    {
        $this->repository = $repository;
    }

    // Afficher tous les utilisateurs
    public function index()
    {
        $users = $this->repository->getAll();
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
        $newUser = $this->repository->create($request->all());
        return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès');
    }

    public function edit($id)
    {
        $user = $this->repository->find($id);
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'Utilisateur introuvable');
        }
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $updatedUser = $this->repository->update($id, $request->all());
        if (!$updatedUser) {
            return redirect()->route('users.index')->with('error', 'Impossible de mettre à jour l\'utilisateur');
        }
        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès');
    }

    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);
        if (!$deleted) {
            return redirect()->route('users.index')->with('error', 'Impossible de supprimer l\'utilisateur');
        }
        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès');
    }
}