<?php

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
    return view('welcome');
});

Route::get('usuarios', 'UserController@index')->name('users');

Route::get('usuarios/nuevo', 'UserController@create')->name('user.create');

Route::post('usuarios', 'UserController@store')->name('user.store');

Route::get('usuarios/{user}/editar', 'UserController@edit')->name('users.edit');

Route::get('usuarios/{user}', 'UserController@show')
    ->name('user.show');

Route::put('usuarios/{user}', 'UserController@update')->name('user.update');

Route::delete('usuarios/{user}', 'UserController@destroy')->name('user.destroy');

Route::get('editar-perfil', 'ProfileController@edit');
Route::put('editar-perfil', 'ProfileController@update');

Route::get('saludo/{name}/{nickname?}', 'WelcomeUserController');
