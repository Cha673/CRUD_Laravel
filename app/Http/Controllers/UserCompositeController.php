<?php

namespace App\Http\Controllers;

use App\Application\Interfaces\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserCompositeController extends Controller
{
    private UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function getUserWithAccounts(int $id): JsonResponse
    {
        $result = $this->userService->getUserWithAccounts($id);
        return response()->json($result);
    }

    public function showUserWithAccounts(int $id)
    {
        $result = $this->userService->getUserWithAccounts($id);
        
        // S'assurer que accounts est toujours un tableau
        $accounts = isset($result['accounts']) ? (is_array($result['accounts']) ? $result['accounts'] : [$result['accounts']]) : [];
        
        $data = [
            'userId' => $id,
            'accounts' => $accounts
        ];
        
        return view('users.details', compact('data'));
    }
}