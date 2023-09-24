<?php

use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersSubscriptonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(static function () {
    Route::get('user/{id}', [SubscriptionController::class, 'list']);

    Route::post('user/{userId}/subscription', [SubscriptionController::class, 'store']);
    Route::put('user/{userId}/subscription/{subscriptionId}', [SubscriptionController::class, 'update']);
    Route::delete('user/{userId}/subscription', [SubscriptionController::class, 'destroy']);

    Route::post('user/{userId}/transaction', [TransactionController::class, 'store']);
});
