<?php

namespace App\Http\Controllers\Api\Users\Account;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\User\UserResource;
use App\Models\Auth\User;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Users\RegisterUserRequest;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    private $users;

    public function __construct(User $users)
    {
        $this->users = $users;
    }

    public function register(RegisterUserRequest $request)
    {
        try {

            $request->merge([
                'password' => Hash::make($request->password)
            ]);

            $this->users->create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Usuário criado com sucesso.',
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Falha ao criar Usuário, verifique os dados informados e tente novamente.',
            ], 400);

        }
    }

}
