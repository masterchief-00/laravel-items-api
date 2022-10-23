<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ItemController;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::get('/items', [ItemController::class, 'index']);
Route::get('/items/{id}', [ItemController::class, 'show']);
Route::post('/signup', [AuthenticationController::class, 'signup']);
Route::post('/login', [AuthenticationController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/items', [ItemController::class, 'store']);
    Route::delete('items/{id}', [ItemController::class, 'destroy']);
    Route::put('/items/{id}', [ItemController::class, 'update']);
    Route::post('/logout', [AuthenticationController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
