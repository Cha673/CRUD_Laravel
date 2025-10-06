<?php 

namespace App\Presentation\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Application\Commands\CreateAccountCommand;
use App\Application\Commands\DeleteAccountCommand;
use App\Application\Handlers\Commands\CreateAccountCommandHandler;
use App\Application\Handlers\Commands\DeleteAccountCommandHandler;
use App\Application\Handlers\Queries\GetAllAccountQueryHandler;

class AccountController extends Controller
{
    public function __construct(
        private CreateAccountCommandHandler $createHandler,
        private DeleteAccountCommandHandler $deleteHandler,
        private GetAllAccountQueryHandler $getAllHandler
    ) {}

    public function index() {
        $accounts = $this->getAllHandler->handle();
        return view('accounts.index', compact('accounts')); // retourne Blade
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'user_id'=>'required|integer',
            'name'=>'required|string|max:255'
        ]);
        $this->createHandler->handle(new CreateAccountCommand($validated['user_id'], $validated['name']));
        return redirect()->back()->with('success', 'Compte créé');
    }

    public function create()
    {
        return view('accounts.create.account');
    }


    public function destroy($id) {
        $this->deleteHandler->handle(new DeleteAccountCommand($id));
        return redirect()->back()->with('success', 'Compte supprimé');
    }
}
