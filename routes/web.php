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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/sports', 'SportsController@sports')->name('sports');
Route::delete('/sports/{sport}', 'SportsController@removeSport');
Route::post('/sports', 'SportsController@addSport');

Route::get('/events', 'EventsController@events')->name('events');
Route::post('/events/{user}', 'EventsController@addEvent');

