<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;

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
// TASKS
Route::group([
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/task/{id}', [TaskController::class, 'getOne']);    
    Route::delete('/task/{id}', [TaskController::class, 'delete']);    
    Route::post('/task', [TaskController::class, 'create']);    
    Route::get('/tasks_user', [TaskController::class, 'getAllByUser']);
    Route::put('/task/{id}', [TaskController::class, 'updateOne']);
    Route::get('/tasks_title/{title}', [TaskController::class, 'getOneByTitle']);
});

// Notes
Route::group([
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/note/{id}', [NoteController::class, 'getOne']);    
    Route::delete('/note/{id}', [NoteController::class, 'delete']);    
    Route::post('/note', [NoteController::class, 'create']);    
    Route::get('/notes_user', [NoteController::class, 'getAllByUser']);
    Route::put('/note/{id}', [NoteController::class, 'updateOne']);
    Route::get('/notes_title/{title}', [NoteController::class, 'getOneByTitle']);
});

// AUTH
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//USERS

Route::group([
    'middleware' => 'jwt.auth'
], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::delete('/user/{id}', [UserController::class, 'delete']);
    Route::put('/user/{id}', [UserController::class, 'updateOne']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
