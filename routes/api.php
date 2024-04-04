<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusinessHoursController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CoordinatorsController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\UserGroupsController;
use Fruitcake\Cors\HandleCors;


Route::get('/consults', [ConsultationController::class, 'index']);
Route::get('/consult/{id}/{user}', [ConsultationController::class, 'show']);
Route::put('/consults', [ConsultationController::class, 'update']);
Route::post('/consult/{id}/{user}', [ConsultationController::class, 'store']);


Route::post('/permission', [PermissionsController::class, 'store']);
Route::post('/permission/{id}/images', [PermissionsController::class, 'updateImage']);
Route::get('/permission', [PermissionsController::class, 'index']);
Route::put('/permission/{idGroup}/connect/{idPermission}', [PermissionsController::class, 'connect']);
Route::get('/permission/groups/{id}', [PermissionsController::class, 'listGroupsPermissions']);
Route::put('/permission/{id}', [PermissionsController::class, 'update']);
Route::delete('/permission/{id}', [PermissionsController::class, 'delete']);


Route::group(['middleware' => ['cors']], function () {

    //login
    Route::post('/signin', [AuthController::class, 'signin']);
    //gerar PDF
    Route::get('/pdf/{id}', [BusinessHoursController::class, 'generation']);


    Route::middleware('auth:sanctum')->group(function () {

        //alterar senha
        Route::post('/forgout', [AuthController::class, 'forgoutPassword']);

        //usuarios
        Route::get('/users', [UsersController::class, "index"]);
        Route::post('/users', [UsersController::class, "store"]);
        Route::put('/users/{id}', [UsersController::class, "update"]);
        Route::patch('/users/release/{id}', [UsersController::class, "release"]);
        Route::delete('/users/{id}', [UsersController::class, 'destroy']);
        Route::get('/users/list/{id}', [UsersController::class, "listUserByGroup"]);

        //coordenadores
        Route::get('/manager', [CoordinatorsController::class, 'index']);
        Route::post('/manager', [CoordinatorsController::class, 'create']);
        Route::put('/manager/{id}', [CoordinatorsController::class, 'update']);
        Route::patch('/manager/release/{id}', [CoordinatorsController::class, 'release']);

        //grupos
        Route::get('/group', [GroupsController::class, 'index']);
        Route::get('/groups', [GroupsController::class, 'listGroups']);
        Route::post('/group', [GroupsController::class, 'create']);
        Route::put('/group/{id}', [GroupsController::class, 'update']);
        Route::patch('/group/release/{id}', [GroupsController::class, 'release']);
        Route::delete('/group/{id}', [GroupsController::class, 'destroy']);

        //registro de ponto
        Route::get('/checkpoint', [BusinessHoursController::class, 'index']);
        Route::post('/checkpoint', [BusinessHoursController::class, 'store']);
        Route::get('/checkpoint/{id}', [BusinessHoursController::class, 'show']);
        Route::get('/checkpoint/users/{id}', [BusinessHoursController::class, 'users']);
        Route::put('/checkpoint/{id}', [BusinessHoursController::class, 'update']);
        Route::patch('/checkpoint/release/{id}', [BusinessHoursController::class, 'release']);
        Route::delete('/checkpoint/{id}', [BusinessHoursController::class, 'destroy']);

        //consulta
        Route::delete('/consult/{id}', [ConsultationController::class, 'destroy']);

        //eventos da agenda
        Route::post('/events', [EventsController::class, 'create']);
        Route::get('/events', [EventsController::class, 'index']);
        Route::put('/events/{id}', [EventsController::class, 'update']);

        //vincular usuario ao grupo
        Route::post('/users/groups', [UserGroupsController::class, 'store']);
    });
});
