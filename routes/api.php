<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResetPasswodController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\Books\BookController;
use App\Http\Controllers\Message\MessageController;
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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/profile', [AuthController::class, 'userProfile']); 
    Route::post('/reset-password-request', [ResetPasswodController::class, 'sendPasswordResetEmail']);
    Route::post('/response-password-reset', [ChangePasswordController::class, 'passwordResetProcess']);

});

Route::group([
    'middleware' => 'api',
], 
function ($router) {
    
    Route::get('/book', [BookController::class, 'index']);
    Route::post('/book/store', [BookController::class, 'store']);
    Route::put('/book/{book}', [BookController::class, 'update']);
    Route::delete('/book/{book}', [BookController::class, 'destroy']);

});

Route::group([
    'middleware' => 'api',
], 
function ($router) {
    
    Route::get('/messages', [MessageController::class, 'index']);
    Route::get('/messages/{message}', [MessageController::class, 'getMessage']);
    Route::post('/messages', [MessageController::class, 'postMessage']);
    Route::delete('/messages/{message}', [MessageController::class, 'deleteMessage']);

});