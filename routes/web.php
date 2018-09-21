<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

// For all visitors ===========
Route::get('/', 'PagesController@home');
Route::get('search', 'PagesController@search');
Route::view('contact', 'pages.contact');
Route::post('admin/feedback', 'Admin\FeedbackController@store');
Route::get('documents/{document}', 'Master\DocumentsController@show');

// Recipes ===========
Route::resource('recipes', 'RecipesController')->except(['destroy']);

// Users ===========
Route::prefix('users')->group(function () {
    Route::get('/', 'UsersController@index');
    Route::get('{user}', 'UsersController@show');

    Route::prefix('other')->middleware('auth')->group(function () {
        Route::get('my-recipes', 'UsersController@my_recipes');
    });
});

// Notifications ===========
Route::prefix('notifications')->middleware('auth')->group(function () {
    Route::get('/', 'NotificationController@index');
    Route::delete('{notification}', 'NotificationController@destroy');
});

// Dashboard ===========
Route::get('dashboard', 'DashboardController@index');

// Settings ===========
Route::prefix('settings')->middleware('auth')->group(function () {
    Route::get('photo/edit', 'Settings\SettingsPhotoController@edit');
    Route::put('photo', 'Settings\SettingsPhotoController@update');

    Route::get('password/edit', 'Settings\SettingsPasswordController@edit');
    Route::put('password', 'Settings\SettingsPasswordController@update');

    Route::get('general/edit', 'Settings\SettingsGeneralController@edit');
    Route::put('general', 'Settings\SettingsGeneralController@update');
});

// Title
Route::prefix('titles')->middleware('admin')->group(function () {
    Route::put('intro', 'TitleController@intro');
    Route::put('footer', 'TitleController@footer');
});

// Artisan commands =======
Route::get('php/artisan/cache/{url_key}', 'ArtisanController@cache');
Route::get('php/artisan/clear/{url_key}', 'ArtisanController@clear');

// Admin ===========
Route::prefix('admin')->namespace('Admin')->middleware('admin')->group(function () {
    Route::get('approves', 'ApprovesController@index');
    Route::get('approves/{recipe}', 'ApprovesController@show');
    Route::post('answer/ok/{recipe}', 'ApprovesController@ok');
    Route::post('answer/cancel/{recipe}', 'ApprovesController@cancel');
    Route::resource('statistics', 'StatisticsController')->only(['index']);
    Route::resource('feedback', 'FeedbackController')->only(['index', 'show', 'destroy']);
});

// Master ==========
Route::prefix('master')->namespace('Master')->middleware('master')->group(function () {
    Route::resource('documents', 'DocumentsController')->except('show');
    Route::delete('log-viewer/logs/delete', 'LogsController@delete');
    Route::resource('visitors', 'VisitorsController')->except(['edit']);
});

// Help =========
Route::resource('help', 'HelpController')->only(['index', 'show']);
