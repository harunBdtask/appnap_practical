<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;

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

Route::controller(AuthController::class)->group(function(){
    Route::post('login','login');
    Route::post('register','register');
});


Route::get('products', [ProductController::class, 'index']);
Route::get('categories', [ProductController::class, 'categories']);
Route::group(['prefix' => 'product'], function () {
    Route::post('save', [ProductController::class, 'save']);
    Route::get('edit/{id}', [ProductController::class, 'edit']);
    Route::delete('delete/{id}', [ProductController::class, 'delete']);
});
