<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusinessHoursController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\UsersController;
//use App\Http\Controllers\TimeController;
use App\Http\Controllers\CoordinatorsController;
use App\Http\Controllers\NonBusinessHourController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//login
Route::post('/login', [AuthController::class, 'login']);

//usuarios
Route::resource('/users', UsersController::class);


//coordenadores
Route::get('/manager', [CoordinatorsController::class, 'index']);
Route::post('/manager', [CoordinatorsController::class, 'create']);
Route::put('/manager/{id}', [CoordinatorsController::class, 'update']);
Route::patch('/manager/release/{id}', [CoordinatorsController::class, 'release']);


Route::get('/group', [GroupsController::class, 'index']);
Route::post('/group', [GroupsController::class, 'create']);
Route::put('/group/{id}', [GroupsController::class, 'update']);
Route::patch('/group/release/{id}', [GroupsController::class, 'release']);

Route::post('/checkpoint', [BusinessHoursController::class, 'create']);
Route::get('/checkpoint', [BusinessHoursController::class, 'index']);
Route::get('/checkpoint/{id}', [BusinessHoursController::class, 'show']);
Route::put('/checkpoint/{id}', [BusinessHoursController::class, 'update']);
