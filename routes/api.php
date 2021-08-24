<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactsController;

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

Route::middleware('auth:api')->group(function () {
    Route::get('/contacts/', [ContactsController::class, 'index']);  
    Route::patch('/contacts/{contact}', [ContactsController::class, 'update']);
    Route::post('/contacts', [ContactsController::class, 'store']);
    Route::get('/contacts/{contact}', [ContactsController::class, 'show']);
    Route::delete('/contacts/{contact}', [ContactsController::class, 'destroy']);
     
});


