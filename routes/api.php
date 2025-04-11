<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



// Route::get('/users', [UserController::class,  'index']); //GET
Route::get('/users/{user}', [UserController::class, 'show']); //GET recomendado colocar o valor = {user} com o mesmo nome da model

Route::post('/users', [UserController::class, 'store']); //POST 

Route::put('/users/{user}', [UserController::class, 'update']); //PUT
Route::delete('/users/{user}', [UserController::class, 'destroy']); //DELETE

//Rotas publicas
Route::post('/login', [LoginController::class, 'login'])->name('login');

//rotas restristas

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::get('/users', [UserController::class, 'index']);
});