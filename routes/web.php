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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify'=>true]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile', 'HomeController@profile')->name('profile');
Route::post('/updateprofile', 'HomeController@updateprofile')->name('updateprofile');
Route::post('/updateprofileimage', 'HomeController@updateprofileimage')->name('updateprofileimage');
Route::get('verifyEmailFirst','Auth\RegisterController@verifyEmailFirst');
Route::get('verification/{email}/{code}','Auth\RegisterController@verification');

