<?php

Route::prefix('recipes')->group(function () {
	Route::get('/', 'Api\ApiRecipesController@index');
	Route::delete('{id}', 'Api\ApiRecipesController@destroy');

	Route::prefix('other')->group(function () {
		Route::get('random/{id}', 'Api\ApiRecipesController@random');
		Route::get('categories', 'Api\ApiRecipesController@categories');
		Route::get('like', 'Api\ApiRecipesController@like');
		Route::get('dislike', 'Api\ApiRecipesController@dislike');
	});
});

Route::get('visitor', 'Api\ApiVisitorController@info');
