<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusinessHoursController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CoordinatorsController;
use App\Http\Controllers\EventsController;
use Fruitcake\Cors\HandleCors;



Route::group(['middleware' => ['cors']], function () {

    //login
    Route::post('/signin', [AuthController::class, 'signin']);
    //gerar PDF
    Route::get('/pdf/{id}', [BusinessHoursController::class, 'generation']);


    Route::middleware('auth:sanctum')->group(function () {

        //usuarios
        Route::get('/users', [UsersController::class, "index"]);
        Route::post('/users', [UsersController::class, "store"]);
        Route::put('/users/{id}', [UsersController::class, "update"]);
        Route::patch('/users/release/{id}', [UsersController::class, "release"]);


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

        //registro de ponto
        Route::get('/checkpoint', [BusinessHoursController::class, 'index']);
        Route::post('/checkpoint', [BusinessHoursController::class, 'store']);
        Route::get('/checkpoint/{id}', [BusinessHoursController::class, 'show']);
        Route::get('/checkpoint/users/{id}', [BusinessHoursController::class, 'users']);
        Route::put('/checkpoint/{id}', [BusinessHoursController::class, 'update']);
        Route::patch('/checkpoint/release/{id}', [BusinessHoursController::class, 'release']);



        //eventos da agenda
        Route::post('/events', [EventsController::class, 'create']);
        Route::get('/events', [EventsController::class, 'index']);
        Route::put('/events/{id}', [EventsController::class, 'update']);
    });
});
