<?php

// All resources
Route::resource('feedback', 'FeedbackController');

// Login and Register
Auth::routes();

// Pages ===========
Route::get('/', 'PagesController@home');
Route::get('search', 'PagesController@search');
Route::view('contact', 'pages.contact');
Route::post('contact', 'ContactController@store');

// Recipes ===========
Route::resource('recipes', 'RecipesController');
Route::prefix('recipes/{recipe}')->group(function () {
	Route::get('like', 'RecipesController@like');
	Route::get('dislike', 'RecipesController@dislike');
	Route::post('answer', 'RecipesController@answer');
});

// Users ===========
Route::resource('users', 'UsersController', ['only' => ['index', 'show']]);
Route::prefix('user/{id}')->group(function () {
	Route::get('add', 'UsersController@add');
	Route::get('delete', 'UsersController@delete');
});

// Dashboard ===========
Route::get('dashboard', 'DashboardController@index');
Route::get('notifications', 'DashboardController@notifications');
Route::get('checklist', 'DashboardController@checklist');
Route::get('my_recipes', 'DashboardController@my_recipes');

// Settings ===========
Route::prefix('settings')->group(function () {
	Route::view('photo', 'settings.photo');
	Route::put('photo', 'SettingsController@updatePhoto');
	Route::view('general', 'settings.general');
	Route::get('titles', 'SettingsController@titles');

	Route::prefix('update')->group(function () {
		Route::put('userData', 'SettingsController@updateUserData');
		Route::put('userPassword', 'SettingsController@updateUserPassword');
		Route::put('bannerData', 'SettingsController@updateBannerData');
		Route::put('introData', 'SettingsController@updateIntroData');
		Route::put('footerData', 'SettingsController@updateFooterData');
	});
});

// Statistic ===========
Route::get('statistic', 'StatisticController@visitors');

// Artisan commands
Route::get('artisan/config/{url_key}', 'ArtisanController@cache');
Route::get('artisan/clear/{url_key}', 'ArtisanController@clear');