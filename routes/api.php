<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Group\CreateGroupController;
use App\Http\Controllers\Group\CreateGroupItemController;
use App\Http\Controllers\Group\GroupListController;
use App\Http\Controllers\Group\JoinGroupController;
use App\Http\Controllers\Wallet\TopUpWalletController;

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

Route::post('/auth/register', RegisterController::class);
Route::post('/auth/login', LoginController::class);
Route::post('/auth/logout', LogoutController::class)->middleware(['auth:sanctum']);

Route::post('/groups', CreateGroupController::class)->middleware(['auth:sanctum']);
Route::post('/groups/join', JoinGroupController::class)->middleware(['auth:sanctum']);
Route::post('/groups/item', CreateGroupItemController::class)->middleware(['auth:sanctum']);
Route::get('/groups/list', GroupListController::class)->middleware(['auth:sanctum']);

Route::post('/wallets/topup', TopUpWalletController::class)->middleware(['auth:sanctum']);
