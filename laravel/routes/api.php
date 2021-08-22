<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemAddonController;
use App\Http\Controllers\ItemAddonOptionController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RestaurantController;
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
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});      
*/
Route::post('login',[AuthController::class,'login']);
Route::post('register',[AuthController::class,'register']);
Route::middleware('auth.token')->group(function(){
    Route::get('/user', function (Request $request) {
        return $request->user();
    }); 
    Route::apiResource('restaurants',RestaurantController::class);
    Route::apiResource('items',ItemController::class);
    Route::apiResource('addons',ItemAddonController::class);
    Route::apiResource('options',ItemAddonOptionController::class);
    Route::post('image', function(Request $request) {
        $path = $request->file('file')->store('images','public');
        return $path;
    });
});
