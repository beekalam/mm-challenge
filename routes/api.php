<?php

use Illuminate\Http\Request;

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
Route::group(['prefix' => 'v1'], function () {

    Route::group(['middleware' => ['guest:api']], function () {
        Route::post('login', 'API\AuthController@login');
        Route::post('signup', 'API\AuthController@signup');
    });

    Route::get("teams", "API\TeamController@index");
    Route::get("teams/{id}", "API\TeamController@show");

    Route::get("players", "API\PlayerController@index");
    Route::get("players/{id}", "API\PlayerController@show");
    Route::group(['middleware' => ['auth:api']], function () {

        //region teams
        Route::post("teams", "API\TeamController@create");
        Route::patch("teams/{id}", "API\TeamController@edit");
        Route::delete("teams/{id}", "API\TeamController@destroy");
        //endregion

        //region players
        Route::post("players", "API\PlayerController@create");
        Route::patch("players/{id}", "API\PlayerController@edit");
        Route::delete("players/{id}", "API\PlayerController@destroy");
        //endregion

    });

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

});

