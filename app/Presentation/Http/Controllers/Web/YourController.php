<?php

namespace App\Presentation\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Users
use App\Application\Interfaces\UserServiceInterface;
use App\Application\DTO\UserDTO;

// Accounts (CQRS)
use App\Application\Commands\CreateAccountCommand;
use App\Application\Commands\DeleteAccountCommand;
use App\Application\Handlers\Commands\CreateAccountCommandHandler;
use App\Application\Handlers\Commands\DeleteAccountCommandHandler;
use App\Application\Handlers\Queries\GetAllAccountQueryHandler;

class YourController extends Controller
{
    protected UserServiceInterface $userService;
    protected CreateAccountCommandHandler $createAccountHandler;
    protected DeleteAccountCommandHandler $deleteAccountHandler;
    protected GetAllAccountQueryHandler $getAllAccountsHandler;

    public function __construct(
        UserServiceInterface $userService,
        CreateAccountCommandHandler $createAccountHandler,
        DeleteAccountCommandHandler $deleteAccountHandler,
        GetAllAccountQueryHandler $getAllAccountsHandler
    ) {
        $this->userService = $userService;
        $this->createAccountHandler = $createAccountHandler;
        $this->deleteAccountHandler = $deleteAccountHandler;
        $this->getAllAccountsHandler = $getAllAccountsHandler;
    }

    // ===================== USERS =====================

    public function index()
    {
        $users = $this->userService->getAllUsers();
        $accounts = $this->getAllAccountsHandler->handle();

        return view('users.index', compact('users', 'accounts'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function add(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email',
            'telephone' => 'required|string|max:20'
        ]);

        $dto = new UserDTO($request->only(['nom','prenom','email','telephone']));
        $newUser = $this->userService->createUser($dto);

        return redirect()->route('users.index')->with('success', 'Utilisateur créé avec le profil : ' . $newUser->profil);
    }

    public function edit($id)
    {
        $user = $this->userService->findUser($id);

        if (!$user) {
            return redirect()->route('users.index')->with('error', 'Utilisateur introuvable');
        }

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email',
            'telephone' => 'required|string|max:20'
        ]);

        $dto = new UserDTO($request->only(['nom','prenom','email','telephone']));
        $updatedUser = $this->userService->updateUser($id, $dto);

        if (!$updatedUser) {
            return redirect()->route('users.index')->with('error', 'Impossible de mettre à jour l\'utilisateur');
        }

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour. Profil : ' . $updatedUser->profil);
    }

    public function destroy($id)
    {
        $deleted = $this->userService->deleteUser($id);

        if (!$deleted) {
            return redirect()->route('users.index')->with('error', 'Impossible de supprimer l\'utilisateur');
        }

        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès');
    }

    // ===================== ACCOUNTS =====================

    // Afficher le formulaire de création de compte (test)
    public function createAccount()
    {
        return view('users.create_account');
    }

    // Créer un compte
    public function storeAccount(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'name' => 'required|string|max:255'
        ]);

        $this->createAccountHandler->handle(new CreateAccountCommand($request->user_id, $request->name));

        return redirect()->route('users.index')->with('success', 'Compte créé');
    }

    // Supprimer un compte
    public function destroyAccount($id)
    {
        $this->deleteAccountHandler->handle(new DeleteAccountCommand($id));

        return redirect()->route('users.index')->with('success', 'Compte supprimé');
    }
}
