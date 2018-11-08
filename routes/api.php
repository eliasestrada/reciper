<?php

Route::get('recipes/{hash?}', 'Api\RecipesController@index');

Route::prefix('like')->namespace('Api')->group(function () {
    Route::post('check/{id}', 'LikeController@check');
    Route::post('like/{id}', 'LikeController@like');
    Route::post('dislike/{id}', 'LikeController@dislike');
});

Route::get('recipes-random/{visitor_id}', 'Api\RandomRecipesController@boot');
