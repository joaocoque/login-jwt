<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Models\Auth\User;

class AuthController extends Controller
{
    public function unauthorized(){
        return response()->json([
            'message' => 'Requisição não autorizada.'
        ], 401);
    }
}

