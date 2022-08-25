<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Auth\User;
use App\Http\Resources\Api\User\UsersResource;
use App\Http\Requests\Api\Users\StoreUserRequest;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    private $users;

    public function __construct(User $users)
    {
        $this->users = $users;
    }
    
    public function store(StoreUserRequest $request)
    {
        DB::beginTransaction();

        try {

            $result = $this->users->create($request->safe()->except(['role']));

            if ($result) {

                $result->assignRole($request->get('role'));

                $result->sendWelcomeNotification();

                DB::commit();

                return response()->json([
                    'message' => 'Usuário criado com sucesso.'
                ], 201);
            }

            DB::rollBack();

            return response()->json([
                'message' => 'Falha ao adicionar Usuário'
            ], 500);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' => 'Falha ao adicionar Usuário'
            ], 500);
        }
    }
}
