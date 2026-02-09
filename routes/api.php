<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



 /**
  * Rutas Api
  */


 /**
  * Login
  */

 
Route::post('auth/login', 'App\Http\Controllers\Api\LoginController@Login');
Route::post('auth/logout', 'App\Http\Controllers\Api\LoginController@Logout')->middleware('auth:sanctum');
Route::get('auth/verify', 'App\Http\Controllers\Api\LoginController@VerifyToken');
Route::get('auth/profile', 'App\Http\Controllers\Api\LoginController@Profile')->middleware('auth:sanctum');
/**
 * Funcion principal
 */

Route::post('GenerarPass','App\Http\Controllers\Api\ApiController@GenerarPass');
Route::post('GenerarCodigo','App\Http\Controllers\Api\ApiController@GenerarCodigo');
Route::post('geofence/nearby','App\Http\Controllers\Api\ApiController@Geocercas');