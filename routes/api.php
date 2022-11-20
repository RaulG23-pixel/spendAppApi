<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\SavingController;
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


Route::post("/register", [AuthController::class, 'register']);
Route::post("/login", [AuthController::class, 'login']);
Route::resource('expense', ExpenseController::class);
Route::resource('saving', SavingController::class);

Route::put("/user/update", [AuthController::class, 'update']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post("/logout", [AuthController::class, 'logout']);
    Route::get("/user", [AuthController::class, 'getUser']);
});
