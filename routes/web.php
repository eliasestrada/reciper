<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\Input;
use App\Recipe;

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
Route::resource('recipes', 'RecipesController');

Auth::routes();
Route::get('/dashboard', 'DashboardController@index')->middleware('author');
Route::get('/notifications', 'DashboardController@notifications')->middleware('author');
Route::get('/checklist', 'DashboardController@checklist')->middleware('admin');
Route::get('/my_recipes', 'DashboardController@my_recipes')->middleware('author');

// Users
Route::get('/users', 'UsersController@index')->middleware('author');
Route::get('/edit', 'UsersController@edit')->middleware('author');
Route::put('/edit', 'UsersController@update')->middleware('author');
Route::get('/users/{user}', 'UsersController@show')->middleware('author');


// Feedback
Route::resource('feedback', 'FeedbackController')->middleware('admin');

// Statistic
Route::get('/statistic', 'StatisticController@visitors')->middleware('admin');