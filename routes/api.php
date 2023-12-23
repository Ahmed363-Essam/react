<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProductController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('Register', [UserController::class, 'Register']);
Route::post('Login', [UserController::class, 'Login']);


Route::get('GetProducts', [ProductController::class, 'index']);
Route::get('ShowOneProduct/{id}', [ProductController::class, 'show']);
Route::post('AddProduct', [ProductController::class, 'store']);
Route::delete('DeleteProduct/{product}', [ProductController::class, 'destroy']);

//Route::apiResource('/product', ProductController::class);
