<?php

Route::prefix('recipes')->group(function () {
    Route::get('{hash?}', 'Api\ApiRecipesController@index');
    Route::delete('{id}', 'Api\ApiRecipesController@destroy');
});

Route::prefix('like')->group(function () {
    Route::post('check/{id}', 'Api\ApiLikeController@check');
    Route::post('like/{id}', 'Api\ApiLikeController@like');
    Route::post('dislike/{id}', 'Api\ApiLikeController@dislike');
});

Route::get('recipes-category', 'Api\ApiRecipesController@categories');
Route::get('recipes-random/{visitor_id}', 'Api\ApiRandomRecipesController@boot');
