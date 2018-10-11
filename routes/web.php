<?php

use Illuminate\Support\Facades\Route;

// For auth users
Auth::routes();
Route::middleware('auth')->group(function () {
    Route::get('statistics', 'StatisticsController@index');
    Route::get('favs/{category?}', 'FavsController@index');
    Route::post('favs/{recipe_id}', 'FavsController@store');
});

Route::prefix('users')->group(function () {
    Route::get('/', 'UsersController@index');
    Route::get('{user}', 'UsersController@show');

    Route::prefix('other')->middleware('auth')->group(function () {
        Route::get('my-recipes', 'UsersController@my_recipes');
    });
});

// For all visitors ===========
Route::get('/', 'PagesController@home');
Route::get('search', 'PagesController@search');
Route::view('contact', 'pages.contact');
Route::post('admin/feedback', 'Admin\FeedbackController@store');
Route::get('documents/{document}', 'Master\DocumentsController@show');

// Recipes ===========
Route::resource('recipes', 'RecipesController')->except(['destroy']);

// Notifications ===========
Route::prefix('notifications')->middleware('auth')->group(function () {
    Route::get('/', 'NotificationController@index');
    Route::delete('{notification}', 'NotificationController@destroy');
});

// Dashboard ===========
Route::get('dashboard', 'DashboardController@index');

// Settings ===========
Route::prefix('settings')->middleware('auth')->namespace('Settings')->group(function () {
    Route::view('/', 'settings.index');

    Route::get('photo/edit', 'PhotoController@edit');
    Route::put('photo', 'PhotoController@update');
    Route::delete('photo', 'PhotoController@destroy');

    Route::get('password/edit', 'PasswordController@edit');
    Route::put('password', 'PasswordController@update');

    Route::get('general/edit', 'GeneralController@edit');
    Route::put('general', 'GeneralController@update');
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
    Route::post('answer/approve/{recipe}', 'ApprovesController@approve');
    Route::post('answer/disapprove/{recipe}', 'ApprovesController@disapprove');
    Route::resource('feedback', 'FeedbackController')->only(['index', 'show', 'destroy']);
});

// Master ==========
Route::prefix('master')->namespace('Master')->middleware('master')->group(function () {
    Route::resource('documents', 'DocumentsController')->except('show');
    Route::delete('log-viewer/logs/delete', 'LogsController@delete');
    Route::resource('visitors', 'VisitorsController')->except(['edit']);
    Route::resource('manage-users', 'ManageUsersController')->except(['edit']);
});

// Help =========
Route::resource('help', 'HelpController')->only(['index', 'show']);
