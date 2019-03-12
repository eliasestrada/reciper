<?php

Route::get('recipes/{hash?}', 'Resourses\RecipeController@index');
Route::get('recipes-random/{visitor_id}', 'Resourses\RandomRecipesController@boot');
