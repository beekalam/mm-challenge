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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/react','HomeController@reactIndex')->name('react.home');

Route::get('/teams', 'TeamController@index')->name('teams.index');
Route::get('/teams/create', 'TeamController@create')->name('teams.create');
Route::get('/teams/{id}', 'TeamController@show')->name('teams.show');
Route::post('/teams/', 'TeamController@store')->name('teams.store');
Route::get('/teams/{id}/edit', 'TeamController@edit')->name('teams.edit');
Route::patch('/teams/{id}', 'TeamController@update')->name('teams.update');
Route::delete('/teams/{id}', 'TeamController@destroy')->name('teams.destroy');

Route::get('/players', 'PlayerController@index')->name('players.index');
Route::get('/players/create', 'PlayerController@create')->name('players.create');
Route::get('/players/{id}', 'PlayerController@show')->name('players.show');
Route::post('/players/', 'PlayerController@store')->name('players.store');
Route::get('/players/{id}/edit', 'PlayerController@edit')->name('players.edit');
Route::patch('/players/{id}', 'PlayerController@update')->name('players.update');
Route::delete('/players/{id}', 'PlayerController@destroy')->name('players.destroy');
