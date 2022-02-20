<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

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

/**
 * ****************************
 * public/test routes
 * ****************************
 */
Route::group(['prefix' => 'v1'], function () {
  Route::controller(AuthController::class)->group(function () {
    Route::group(['prefix' => 'user'], function () {
      Route::get('register', 'register');
      Route::post('login', 'login');
    });
  });
});


/**
 * **************************
 * Protected Routes
 * **************************
 */
Route::group(['middleware' => 'auth:api', 'prefix' => 'v1'], function () {
  Route::controller(AuthController::class)->group(function () {
    Route::group(['prefix' => 'user'], function () {
      Route::get('/get/{user}', 'user');
      Route::post('/logout', 'logout');
    });
  });
});
