<?php

Route::get('recipes/{hash?}', 'Api\RecipeController@index');
Route::get('recipes-random/{visitor_id}', 'Api\RandomRecipesController@boot');
