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


Route::get('show-random-recipes/{id}', 'Api\ApiRecipesController@showRandomRecipes');

Route::prefix('recipes')->group(function () {
	Route::get('/', 'Api\ApiRecipesController@index');
	Route::delete('{id}', 'Api\ApiRecipesController@destroy');
	Route::get('categories', 'Api\ApiRecipesController@categories');
});
