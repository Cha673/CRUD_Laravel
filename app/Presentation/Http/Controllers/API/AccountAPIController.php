<?php 
namespace App\Presentation\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Application\Commands\CreateAccountCommand;
use App\Application\Commands\DeleteAccountCommand;
use App\Application\Handlers\Commands\CreateAccountCommandHandler;
use App\Application\Handlers\Commands\DeleteAccountCommandHandler;
use App\Application\Handlers\Queries\GetAllAccountQueryHandler;

class AccountAPIController extends Controller
{
    public function __construct(
        private CreateAccountHandler $createHandler,
        private DeleteAccountHandler $deleteHandler,
        private GetAllAccountsHandler $getAllHandler
    ) {}

    public function index() { return response()->json($this->getAllHandler->handle()); }
    public function store(Request $request) { 
        $validated = $request->validate([
            'user_id'=>'required|integer',
            'name'=>'required|string|max:255'
        ]);
        $account = $this->createHandler->handle(new CreateAccountCommand($validated['user_id'], $validated['name']));
        return response()->json($account, 201);
    }
    public function destroy($id) {
        $success = $this->deleteHandler->handle(new DeleteAccountCommand($id));
        return response()->json($success ? ['message'=>'Compte supprimé'] : ['message'=>'Compte non trouvé'], $success ? 200 : 404);
    }
}
