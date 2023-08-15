<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\UsersController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//login
Route::post('/login', [AuthController::class, 'login']);

//usuarios
Route::get('/users', [UsersController::class, 'index']);
Route::post('/users', [UsersController::class, 'register']);
Route::put('/users/{id}', [UsersController::class, 'update']);
Route::put('/users/{id}', [UsersController::class, 'release']);

Route::get('/group', [GroupsController::class, 'index']);
Route::post('/group', [GroupsController::class, 'create']);
Route::put('/group/{id}', [GroupsController::class, 'update']);




