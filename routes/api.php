<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Group\CreateGroupController;
use App\Http\Controllers\Group\CreateGroupItemController;
use App\Http\Controllers\Group\GetGroupItemListController;
use App\Http\Controllers\Group\GetGroupMemberListController;
use App\Http\Controllers\Group\GetHistoriesPaymentGroupItemController;
use App\Http\Controllers\Group\GroupListController;
use App\Http\Controllers\Group\JoinGroupController;
use App\Http\Controllers\Group\PayGroupItemController;
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
Route::get('/groups', GroupListController::class)->middleware(['auth:sanctum']);
Route::post('/groups/join', JoinGroupController::class)->middleware(['auth:sanctum']);

Route::post('/groups/{group_code}/items', CreateGroupItemController::class)->middleware(['auth:sanctum']);
Route::get('/groups/{group_code}/items', GetGroupItemListController::class)->middleware(['auth:sanctum']);
Route::get('/groups/{group_code}/members', GetGroupMemberListController::class)->middleware(['auth:sanctum']);

Route::post('/groups/{group_code}/items/{item_id}/pay', PayGroupItemController::class)->middleware(['auth:sanctum']);
Route::post('/groups/items/{item_id}/pay/history', GetHistoriesPaymentGroupItemController::class)->middleware(['auth:sanctum']);


Route::post('/wallets/topup', TopUpWalletController::class)->middleware(['auth:sanctum']);
