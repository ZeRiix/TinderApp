<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

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

Route::get('/hello', [Controller::class, 'index']);
Route::post('/add-user', [Controller::class, 'addUser']);
Route::get('/get-users', [Controller::class, 'getUsers']);
Route::post('/login', [Controller::class, 'authUser']);
Route::post('delete-user', [Controller::class, 'delUser']);
Route::post('get-user', [Controller::class, 'getUser']);
Route::post('update-user', [Controller::class, 'updateUser']);
