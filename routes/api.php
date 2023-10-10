<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CargosController;
use App\Http\Controllers\DizimoController;
use App\Http\Controllers\MembersController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return 'Olá, mundo!';
});

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function() {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class,'register'])->name('register');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/logged-user', [AuthController::class,'getLoggedUser'])->name('getLoggedUser');
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'users'], function() {
    Route::get('/', [UsersController::class, 'index']);
    Route::post('/create', [UsersController::class,'create']);
    Route::put('/edit/{id}', [UsersController::class, 'edit']);
    Route::delete('/delete/{id}', [UsersController::class, 'delete']);
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'cargos'], function() {
    Route::get('/', [CargosController::class, 'index']);
    Route::post('/create', [CargosController::class,'create']);
    Route::put('/edit/{id}', [CargosController::class, 'edit']);
    Route::delete('/delete/{id}', [CargosController::class, 'delete']);
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'members'], function() {
    Route::get('/', [MembersController::class, 'index']);
    Route::get('/{id}', [MembersController::class, 'index']);
    Route::post('/create', [MembersController::class,'create']);
    Route::put('/edit/{id}', [MembersController::class, 'edit']);
    Route::delete('/delete/{id}', [MembersController::class, 'delete']);
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'dizimos'], function() {
    Route::get('/', [DizimoController::class, 'index']);
    Route::post('/create', [DizimoController::class,'create']);
    Route::put('/edit/{id}', [DizimoController::class, 'edit']);
    Route::delete('/delete/{id}', [DizimoController::class, 'delete']);
});
