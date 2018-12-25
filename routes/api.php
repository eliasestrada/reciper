<?php

Route::get('recipes/{hash?}', 'Api\RecipesController@index');
Route::get('recipes-random/{visitor_id}', 'Api\RandomRecipesController@boot');
