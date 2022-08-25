<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use app\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\SessionController;
use app\Http\Controllers\Api\Auth\ActivationController;
use App\Http\Controllers\Api\Users\Account\AccountController;
use App\Http\Controllers\Api\Role\RoleController;
use App\Http\Controllers\Api\Permission\PermissionController;
use App\Http\Controllers\Api\Faqs\FaqCategoryController;
use App\Http\Controllers\Api\Faqs\FaqController;

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

        Route::get('/dale', function(){
            return ['doly'=> true];
        });

        //logout
        Route::post('auth/logout', [SessionController::class, 'logout']);

        //Roles
        Route::get('/campos-permissoes', [RoleController::class, 'permissions']);
        Route::prefix('/grupos')->group(function () {
            Route::get('/', [RoleController::class, 'index']);
            Route::get('{id}', [RoleController::class, 'show']);
            Route::post('/', [RoleController::class, 'store']);
            Route::put('/{id}', [RoleController::class, 'update']);
            Route::delete('/{id}', [RoleController::class, 'destroy']);
        });

        //Permission
        Route::get('/campos-grupos', [PermissionController::class, 'roles']);
        Route::prefix('/permissoes')->group(function () {
            Route::get('/', [PermissionController::class, 'index']);
            Route::get('/{id}', [PermissionController::class, 'show']);
            Route::post('/', [PermissionController::class, 'store']);
            Route::put('/{id}', [PermissionController::class, 'update']);
            Route::delete('/{id}', [PermissionController::class, 'destroy']);
        });
    });

        //Faq
        Route::prefix('/perguntas')->group(function () {
            Route::get('/', [FaqController::class, 'index']);
            Route::get('/{uuid}', [FaqController::class, 'show']);
            Route::post('/', [FaqController::class, 'store']);
            Route::put('/{uuid}', [FaqController::class, 'update']);
            Route::delete('/{uuid}', [FaqController::class, 'destroy']);
        });

        //Faq Category
        Route::prefix('/categorias-faq')->group(function () {
            Route::get('/', [FaqCategoryController::class, 'index']);
            Route::get('/{uuid}', [FaqCategoryController::class, 'show']);
            Route::post('/', [FaqCategoryController::class, 'store']);
            Route::put('/{uuid}', [FaqCategoryController::class, 'update']);
            Route::delete('/{uuid}', [FaqCategoryController::class, 'destroy']);
        });

});
