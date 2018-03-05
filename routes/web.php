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
Route::get('/recipes/{recipe}/dislike', 'RecipesController@dislike');
Route::post('/recipes/{recipe}/answer', 'RecipesController@answer');
Route::resource('recipes', 'RecipesController');


// Users
Route::get('/dashboard', 'DashboardController@index')->middleware('author');
Route::get('/notifications', 'DashboardController@notifications')->middleware('author');
Route::get('/checklist', 'DashboardController@checklist')->middleware('admin');
Route::get('/my_recipes', 'DashboardController@my_recipes')->middleware('author');

// -----------------------
// Auth::routes();
// Authentication Routes...
$this->get('яхочувойти', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('яхочувойти', 'Auth\LoginController@login');
$this->post('яхочувыйти', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
$this->get('яхочузарегестрироваться', 'Auth\RegisterController@showRegistrationForm')->name('register');
$this->post('яхочузарегестрироваться', 'Auth\RegisterController@register');

// Password Reset Routes...
$this->get('777/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('777/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('777/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('777/password/reset', 'Auth\ResetPasswordController@reset');