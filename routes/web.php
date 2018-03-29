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
Route::post('/contact', 'ContactController@store');

// Recipes
Route::get('/recipes/{recipe}/like', 'RecipesController@like');
Route::get('/recipes/{recipe}/dislike', 'RecipesController@dislike');
Route::post('/recipes/{recipe}/answer', 'RecipesController@answer');

// Users
Route::resource('users', 'UsersController', ['only' => ['index', 'show']]);
Route::get('/user/{id}/add', 'UsersController@add');
Route::get('/user/{id}/delete', 'UsersController@delete');

// Dashboard
Route::get('/dashboard', 'DashboardController@index');
Route::get('/notifications', 'DashboardController@notifications');
Route::get('/checklist', 'DashboardController@checklist');
Route::get('/my_recipes', 'DashboardController@my_recipes');

// Settings
Route::get('/settings', 'SettingsController@index');
Route::get('/settings/photo', 'SettingsController@editPhoto');
Route::put('/settings/photo', 'SettingsController@updatePhoto');
Route::get('/settings/general', 'SettingsController@general');
Route::get('/settings/titles', 'SettingsController@titles');
Route::put('/settings/updateBannerData', 'SettingsController@updateBannerData');
Route::put('/settings/updateUserData', 'SettingsController@updateUserData');
Route::put('/settings/updateUserPassword', 'SettingsController@updateUserPassword');

// Statistic
Route::get('/statistic', 'StatisticController@visitors');