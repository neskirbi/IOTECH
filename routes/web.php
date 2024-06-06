<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    if(Auth::guard('superusuarios')->check()){
        return redirect('administradores');
    }  



    return view('home.home');
});


Route::resource('login', 'App\Http\Controllers\Login\LoginController');
Route::get('logout', 'App\Http\Controllers\Login\LoginController@Logout');
Route::get('newpass/{id}/{temp}', 'App\Http\Controllers\Login\LoginController@NewPass');


Route::post('Ingresar', 'App\Http\Controllers\Login\LoginController@Ingresar');



/**
 * Rutas Super Usuarios
 */

 Route::resource('empresas', 'App\Http\Controllers\SuperUsuario\EmpresaController');
 Route::get('BorrarEmpresa/{id}', 'App\Http\Controllers\SuperUsuario\EmpresaController@BorrarEmpresa');

 Route::resource('administradores', 'App\Http\Controllers\SuperUsuario\AdministradorController');
 Route::get('BorrarAdmin/{id}', 'App\Http\Controllers\SuperUsuario\AdministradorController@BorrarAdmin');



  