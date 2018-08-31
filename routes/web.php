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

Route::get('/', 'PagesController@root')->name('root');
Route::get('select/plan','PagesController@plan')->name('select.plan');
Route::get('select/select','PagesController@select')->name('select.select');

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
//Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
//Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::resource('users','UsersController',['only' => ['show', 'update', 'edit']]);

Route::put('examinations', 'ExaminationsController@plan')->name('examinations.plan');
Route::post('examinations', 'ExaminationsController@select')->name('examinations.select');
Route::post('examinations/export', 'ExaminationsController@export')->name('examinations.export');
Route::get('examinations/{examination}', 'ExaminationsController@show')->name('examinations.show');

Route::get('permission-denied', 'PagesController@permissionDenied')->name('permission-denied');