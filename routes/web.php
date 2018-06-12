<?php

Auth::routes();

// Pages ===========
Route::get('/', 'PagesController@home');
Route::get('search', 'PagesController@search');
Route::view('contact', 'pages.contact');
Route::post('contact', 'ContactController@store');

// Recipes ===========
Route::resource('recipes', 'RecipesController')->except(['destroy']);
Route::prefix('recipes/{recipe}')->group(function () {
	Route::get('like', 'RecipesController@like');
	Route::get('dislike', 'RecipesController@dislike');
});

// Users ===========
Route::prefix('users')->group(function () {
	Route::get('/', 'UsersController@index');
	Route::get('{user}', 'UsersController@show');

	Route::prefix('other')->group(function () {
		Route::get('my_recipes', 'UsersController@my_recipes');
		Route::get('notifications', 'UsersController@notifications');
	});
});


// New Member ========
Route::prefix('member/{id}')->group(function () {
	Route::get('add', 'NewMemberController@add');
	Route::get('delete', 'NewMemberController@delete');
});

// Dashboard ===========
Route::get('dashboard', 'DashboardController@index');

// Settings ===========
Route::prefix('settings')->group(function () {
	Route::get('photo', 'SettingsController@photo');
	Route::put('photo', 'SettingsController@updatePhoto');
	Route::get('general', 'SettingsController@general');

	Route::prefix('update')->group(function () {
		Route::put('userData', 'SettingsController@updateUserData');
		Route::put('userPassword', 'SettingsController@updateUserPassword');
		Route::put('bannerData', 'SettingsController@updateBannerData');
		Route::put('introData', 'SettingsController@updateIntroData');
		Route::put('footerData', 'SettingsController@updateFooterData');
	});
});

// Approving ======
Route::post('answer/ok/{recipe}', 'ApproveController@ok');
Route::post('answer/cancel/{recipe}', 'ApproveController@cancel');


// Artisan commands =======
Route::get('php/artisan/cache/{url_key}', 'ArtisanController@cache');
Route::get('php/artisan/clear/{url_key}', 'ArtisanController@clear');

// Admin ===========
Route::prefix('admin')->group(function () {
	Route::get('checklist', 'AdminController@checklist');
	Route::get('statistic', 'AdminController@visitors');
	Route::get('feedback', 'AdminController@feedback');
	Route::delete('feedback/{id}', 'AdminController@feedbackDestroy');
});