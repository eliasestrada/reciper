<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

// Web APIs
Route::middleware('auth')->namespace('WebApi')->group(function () {
    Route::get('popularity-chart', 'StatisticsController@popularityChart');
    Route::get('favs/{category?}', 'FavsController@index');
    Route::post('favs/{recipe_id}', 'FavsController@store');
    Route::post('like/{recipe_id}', 'LikeController@store');
});

// Statistics
Route::middleware('auth')->group(function () {
    Route::get('statistics', 'StatisticsController@index');
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

Route::resource('documents', DocumentsController::class);
Route::resource('recipes', RecipesController::class);
Route::resource('help', HelpController::class);

// Dashboard ===========
Route::get('dashboard', 'DashboardController@index');

// Settings ===========
Route::prefix('settings')->middleware('auth')->namespace('Settings')->group(function () {
    Route::view('/', 'settings.general.index');
    Route::get('general', 'GeneralController@index');
    Route::put('general', 'GeneralController@updateGeneral');
    Route::put('password', 'GeneralController@updatePassword');
    Route::put('email', 'GeneralController@updateEmail');

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
    Route::delete('log-viewer/logs/delete', 'LogsController@delete');
    Route::resource('visitors', VisitorsController::class)->except(['edit']);
    Route::resource('manage-users', ManageUsersController::class)->except(['edit']);
    Route::resource('trash', TrashController::class)->only(['index', 'destroy', 'update']);
});

// Invokes
Route::prefix('invokes')->namespace('Invokes')->group(function () {
    Route::get('dark-theme-switcher/{state}', DarkThemeController::class);
    Route::get('font-size-switcher/{font_size}', FontSizeController::class);
    Route::post('download-ingredients/{recipe_id}', DownloadIngredientsController::class);
    Route::get('verify-email/{token}', VerifyEmailController::class);
    Route::put('notifications', NotificationController::class)->middleware('auth');
});
