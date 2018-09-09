<?php

Route::prefix('recipes')->group(function () {
    Route::get('/', 'Api\ApiRecipesController@index');
    Route::delete('{id}', 'Api\ApiRecipesController@destroy');

    Route::prefix('other')->group(function () {
        Route::get('random/{visitor_id}', 'Api\ApiRecipesController@random');
        Route::get('categories', 'Api\ApiRecipesController@categories');
        Route::post('check-if-liked/{id}', 'Api\ApiRecipesController@checkIfLiked');
        Route::post('like/{id}', 'Api\ApiRecipesController@like');
        Route::post('dislike/{id}', 'Api\ApiRecipesController@dislike');
    });
});
