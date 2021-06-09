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
Route::get('/home', 'HomeController@index')->name('home');

Route::auth();

Route::prefix('contacts')->group(function () {
    Route::get('/', 'ContactsController@index')->name('contacts.index')->middleware('auth');
    Route::get('/list', 'ContactsController@list')->name('contacts.list')->middleware('auth');
    Route::get('/create', 'ContactsController@create')->name('contacts.create')->middleware('auth');
    Route::post('/store', 'ContactsController@store')->name('contacts.store')->middleware('auth');
    Route::get('/{id}/edit', 'ContactsController@edit')->name('contacts.edit')->middleware('auth');
    Route::put('/{id}', 'ContactsController@update')->name('contacts.update')->middleware('auth');
    Route::delete('/{id}', 'ContactsController@destroy')->name('contacts.delete')->middleware('auth');
});

Route::get('/', 'auth\LoginController@index');
Route::get('/login', 'auth\LoginController@index')->name('login');
Route::post('/login', 'auth\LoginController@authenticate')->name('authenticate');

Route::get('/registro', 'auth\RegisterController@index')->name('register');
Route::post('/registro', 'auth\RegisterController@create')->name('register');
