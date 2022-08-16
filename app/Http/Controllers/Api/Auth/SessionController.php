<?php

namespace App\Http\Controllers\Api\Auth;



use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Models\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{

    public function login(LoginRequest $request)
    {
        $user = User::select('id', 'uuid', 'password', 'email')
        ->where('email', $request->email)
        ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Email não encontrado.',
            ], 404);
        }

        $credentials = request(['email', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json([
                'message' => 'Usuário não encontrado, por favor verifique seus dados.',
            ], 404);
        }

        $user = auth('api')->user();

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Deslogado com sucesso!']);
    }

    protected function respondWithToken($token)
    {
        $user = auth()->guard('api')->user();

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
            ],
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL(),
        ]);
    }
}
