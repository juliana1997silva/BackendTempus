<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\UsersController;
//use App\Http\Controllers\TimeController;
use App\Http\Controllers\CoordinatorsController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//login
Route::post('/login', [AuthController::class, 'login']);

//usuarios
Route::get('/users', [UsersController::class, 'index']);
Route::post('/users', [UsersController::class, 'register']);
Route::put('/users/{id}', [UsersController::class, 'update']);
Route::patch('/users/release/{id}', [UsersController::class, 'release']);

//coordenadores
Route::get('/manager', [CoordinatorsController::class, 'index']);
Route::post('/manager', [CoordinatorsController::class, 'create']);
Route::put('/manager/{id}', [CoordinatorsController::class, 'update']);
Route::patch('/manager/release/{id}', [CoordinatorsController::class, 'release']);

//grupos
Route::get('/group', [GroupsController::class, 'index']);
Route::post('/group', [GroupsController::class, 'create']);
Route::put('/group/{id}', [GroupsController::class, 'update']);
Route::patch('/group/release/{id}', [GroupsController::class, 'release']);


//times
//Route::get('/times', [TimeController::class, 'index']);
//Route::get('/time/{id}', [TimeController::class, 'show']);
//Route::post('/time', [TimeController::class, 'create']);
