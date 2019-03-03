<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

// Web APIs
Route::namespace ('Api')->group(function () {
    Route::get('popularity-chart', 'StatisticController@popularityChart');
    Route::post('favs/{recipe}', 'FavController@store');
    Route::post('likes/{recipe}', 'LikeController@store');
});

Route::get('favs/{category?}', 'FavController@index');
Route::get('statistics', 'StatisticController@index');

Route::prefix('users')->group(function () {
    Route::get('/', 'UserController@index');
    Route::get('{username}', 'UserController@show');
    Route::delete('delete/{id}', 'UserController@destroy');
    Route::post('/', 'UserController@store');

    Route::prefix('other')->group(function () {
        Route::get('my-recipes', 'UserController@my_recipes');
    });
});

// For all visitors ===========
Route::get('/', 'PageController@home');
Route::view('contact', 'pages.contact');
Route::get('search', 'PageController@search');
Route::post('admin/feedback', 'Admin\FeedbackController@store');

Route::resource('recipes', RecipeController::class);
Route::resource('help', HelpController::class)->only(['index', 'show']);
Route::resource('documents', DocumentController::class)->only(['index', 'show']);

// Dashboard ===========
Route::get('dashboard', 'DashboardController@index');

// Settings ===========
Route::prefix('settings')->namespace('Settings')->group(function () {
    Route::view('/', 'settings.general.index')->middleware('auth');
    Route::get('general', 'GeneralController@index');
    Route::put('general', 'GeneralController@updateGeneral');
    Route::put('password', 'GeneralController@updatePassword');
    Route::put('email', 'GeneralController@updateEmail');

    Route::get('photo', 'PhotoController@index');
    Route::put('photo', 'PhotoController@update');
    Route::delete('photo', 'PhotoController@destroy');
});

// Admin ===========
Route::prefix('admin')->namespace('Admin')->group(function () {
    Route::get('approves', 'ApproveController@index');
    Route::get('approves/{slug}', 'ApproveController@show');
    Route::post('answer/approve/{slug}', 'ApproveController@approve');
    Route::post('answer/disapprove/{slug}', 'ApproveController@disapprove');
    Route::resource('feedback', FeedbackController::class)->only(['index', 'show', 'destroy']);
});

// Master ==========
Route::prefix('master')->namespace('Master')->group(function () {
    Route::delete('log-viewer/logs/destroy', 'LogController@destroy')->middleware('master');
    Route::resource('visitors', VisitorController::class)->except(['edit']);
    Route::resource('documents', DocumentController::class)->except(['index', 'show']);
    Route::resource('help', HelpController::class)->except(['index', 'show']);
    Route::resource('manage-users', ManageUserController::class)->except(['edit']);
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
