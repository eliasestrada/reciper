<?php

Route::prefix('recipes')->namespace('Api')->group(function () {
    Route::get('{hash?}', 'RecipesController@index');
    Route::delete('{id}', 'RecipesController@destroy');
});

Route::prefix('like')->namespace('Api')->group(function () {
    Route::post('check/{id}', 'LikeController@check');
    Route::post('like/{id}', 'LikeController@like');
    Route::post('dislike/{id}', 'LikeController@dislike');
});

Route::get('recipes-random/{visitor_id}', 'Api\RandomRecipesController@boot');
