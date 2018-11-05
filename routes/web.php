<?php

use Illuminate\Support\Facades\Route;

// For auth users
Auth::routes();
Route::middleware('auth')->group(function () {
    Route::get('statistics', 'StatisticsController@index');
    Route::get('favs/{category?}', 'FavsController@index');
    Route::post('favs/{recipe_id}', 'FavsController@store');
});

// Api routes with in web enviroment
Route::namespace ('Api')->middleware('auth')->group(function () {
    Route::get('api-statistics/popularity-chart', 'StatisticsController@popularityChart');
});

Route::prefix('users')->group(function () {
    Route::get('/', 'UsersController@index');
    Route::get('{username}', 'UsersController@show');
    Route::delete('delete/{d}', 'UsersController@destroy');
    Route::post('/', 'UsersController@store');

    Route::prefix('other')->middleware('auth')->group(function () {
        Route::get('my-recipes', 'UsersController@my_recipes');
    });
});

// For all visitors ===========
Route::get('/', 'PagesController@home');
Route::get('search', 'PagesController@search');
Route::view('contact', 'pages.contact');
Route::post('admin/feedback', 'Admin\FeedbackController@store');
Route::get('documents/{document}', 'Master\DocumentsController@show')->where('document', '[0-9]+');

// Recipes ===========
Route::resource('recipes', RecipesController::class);

// Notifications ===========
Route::get('notifications', 'NotificationController@index')->middleware('auth');

// Dashboard ===========
Route::get('dashboard', 'DashboardController@index');

// Settings ===========
Route::prefix('settings')->middleware('auth')->namespace('Settings')->group(function () {
    Route::view('/', 'settings.general.index');
    Route::get('general', 'GeneralController@index');
    Route::put('general', 'GeneralController@updateGeneral');
    Route::put('password', 'GeneralController@updatePassword');

    Route::get('photo', 'PhotoController@index');
    Route::put('photo', 'PhotoController@update');
    Route::delete('photo', 'PhotoController@destroy');
});

// Artisan commands =======
Route::get('php/artisan/cache/{url_key}', 'ArtisanController@cache');
Route::get('php/artisan/clear/{url_key}', 'ArtisanController@clear');

// Admin ===========
Route::prefix('admin')->namespace('Admin')->middleware('admin')->group(function () {
    Route::get('approves', 'ApprovesController@index');
    Route::get('approves/{recipe}', 'ApprovesController@show');
    Route::post('answer/approve/{recipe}', 'ApprovesController@approve');
    Route::post('answer/disapprove/{recipe}', 'ApprovesController@disapprove');
    Route::resource('feedback', FeedbackController::class)->only(['index', 'show', 'destroy']);
});

// Master ==========
Route::prefix('master')->namespace('Master')->middleware('master')->group(function () {
    Route::resource('documents', DocumentsController::class)->except('show');
    Route::delete('log-viewer/logs/delete', 'LogsController@delete');
    Route::resource('visitors', VisitorsController::class)->except(['edit']);
    Route::resource('manage-users', ManageUsersController::class)->except(['edit']);
});

// Help =========
Route::resource('help', HelpController::class)->only(['index', 'show']);

// Invokes
Route::get('invokes/dark-theme-switcher/{state}', Invokes\DarkThemeController::class);
Route::post('invokes/download-ingredients/{recipe_id}', Invokes\DownloadIngredientsController::class);
