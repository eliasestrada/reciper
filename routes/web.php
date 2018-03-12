<?php

// All resources
Route::resources([
	'recipes' => 'RecipesController',
	'feedback' => 'FeedbackController'
]);

// Login and Register
Auth::routes();

// Pages
Route::get('/', 'PagesController@home');
Route::get('/search', 'PagesController@search');
Route::get('/contact', 'ContactController@index');
Route::post('/contact', [
	'uses' => 'ContactController@store',
	'as' => 'contact.store'
]);

// Recipes
Route::get('/recipes/{recipe}/like', 'RecipesController@like');
Route::get('/recipes/{recipe}/dislike', 'RecipesController@dislike');
Route::post('/recipes/{recipe}/answer', 'RecipesController@answer');

// Users
Route::resource('users', 'UsersController', ['only' => [
	'index', 'show'
]]);

// Dashboard
Route::get('/dashboard', 'DashboardController@index');
Route::get('/notifications', 'DashboardController@notifications');
Route::get('/checklist', 'DashboardController@checklist');
Route::get('/my_recipes', 'DashboardController@my_recipes');

// Settings
Route::get('/settings', 'SettingsController@index');
Route::get('/settings/photo', 'SettingsController@editPhoto');
Route::put('/settings/photo', 'SettingsController@updatePhoto');

// Statistic
Route::get('/statistic', 'StatisticController@visitors');