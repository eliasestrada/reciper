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
Route::get('/contact', 'PagesController@contact');
Route::get('/search', 'PagesController@search');

// Recipes
Route::get('/recipes/{recipe}/like', 'RecipesController@like');
Route::post('/recipes/{recipe}/answer', 'RecipesController@answer');
Route::resource('recipes', 'RecipesController');
Auth::routes();

// Users
Route::get('/dashboard', 'DashboardController@index');
Route::get('/notifications', 'DashboardController@notifications');
