<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use app\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use app\Http\Controllers\Api\Auth\ActivationController;
use App\Http\Controllers\Api\Users\Account\AccountController;
use App\Http\Controllers\Api\Auth\SessionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {

    Route::get('/dale', function(){
        return ['doly'=> true];
    });

    Route::get('/401', [AuthController::class, 'unauthorized'])->name('login');

    Route::post('/cadastro', [AccountController::class, 'register']);

    Route::post('/login', [SessionController::class, 'login']);


    // Route::post('/primeiro-acesso', [ActivationController::class, 'store']);


    Route::middleware(('auth:api'))->group(function(){
        Route::post('auth/validate', [AuthController::class, 'validateToken']);
        Route::post('auth/logout', [SessionController::class, 'logout']);


    });

});
