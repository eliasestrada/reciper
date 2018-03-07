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


// Users
Route::resource('users', 'UsersController')
		->middleware('author');
Route::get('/dashboard', 'DashboardController@index')
		->middleware('author');
Route::get('/notifications', 'DashboardController@notifications')
		->middleware('author');
Route::get('/checklist', 'DashboardController@checklist')
		->middleware('admin');
Route::get('/my_recipes', 'DashboardController@my_recipes')
		->middleware('author');
Auth::routes();