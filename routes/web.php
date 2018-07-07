<?php

Auth::routes();

// Logs (This route overwrites delete method from log-viewer package)
Route::delete('/log-viewer/logs/delete', 'LogsController@delete');

// Pages ===========
Route::get('/', 'PagesController@home');
Route::get('search', 'PagesController@search');
Route::view('contact', 'pages.contact');
Route::post('contact', 'ContactController@store');

// Recipes ===========
Route::resource('recipes', 'RecipesController')->except(['destroy']);

// Users ===========
Route::prefix('users')->group(function () {
	Route::get('/', 'UsersController@index');
	Route::get('{user}', 'UsersController@show');

	Route::prefix('other')->group(function () {
		Route::get('my-recipes', 'UsersController@my_recipes');
	});
});

Route::prefix('notifications')->group(function () {
	Route::get('/', 'NotificationController@index');
	Route::delete('{notification}', 'NotificationController@destroy');
});

// Dashboard ===========
Route::get('dashboard', 'DashboardController@index');

// Settings ===========
Route::prefix('settings')->group(function () {
	Route::get('photo', 'SettingsController@photo');
	Route::put('photo', 'SettingsController@updatePhoto');
	Route::get('general', 'SettingsController@general');

	Route::prefix('update')->group(function () {
		Route::put('user-data', 'SettingsController@updateUserData');
		Route::put('user-password', 'SettingsController@updateUserPassword');
		Route::put('intro-data', 'SettingsController@updateIntroData');
		Route::put('footer-data', 'SettingsController@updateFooterData');
	});
});

// Approving ======
Route::post('answer/ok/{recipe}', 'ApproveController@ok');
Route::post('answer/cancel/{recipe}', 'ApproveController@cancel');

// Artisan commands =======
Route::get('php/artisan/cache/{url_key}', 'ArtisanController@cache');
Route::get('php/artisan/clear/{url_key}', 'ArtisanController@clear');

// Admin ===========
Route::prefix('admin')->namespace('Admin')->group(function () {
	Route::prefix('statistics')->group(function () {
		Route::get('/', 'StatisticsController@index');
	});

	Route::prefix('checklist')->group(function () {
		Route::get('/', 'ChecklistController@index');
	});

	Route::prefix('documents')->group(function () {
		Route::get('/', 'DocumentsController@index');
	});

	Route::prefix('feedback')->group(function () {
		Route::get('/', 'FeedbackController@index');
		Route::delete('destroy/{id}', 'FeedbackController@destroy');
	});
});