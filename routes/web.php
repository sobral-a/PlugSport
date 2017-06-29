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

Route::get('/eventsAdmin', 'EventsController@eventsAdmin')->name('eventsAdmin');
Route::delete('/events/{event}', 'EventsController@removeEvent');
Route::get('/events/{user}', 'EventsController@events');
Route::post('/events/{user}', 'EventsController@addEvent');
Route::get('/events/{event}/view', 'EventsController@eventView');


Route::get('/teams/{user}', 'TeamsController@teams');
Route::delete('/teams/{team}', 'TeamsController@removeTeam');
Route::post('/teams/{user}', 'TeamsController@addTeam');
Route::patch('/teams/{team}/ban', 'TeamsController@banTeam');
Route::patch('/teams/{team}', 'TeamsController@allowTeam');

Route::get('/teams/{user}/player', 'TeamsController@playerTeams');
Route::get('/teams/{team}/view', 'TeamsController@teamView');

Route::delete('/players/{team}/{user}', 'PlayersController@removeUserTeam');
Route::post('/players/{team}/{user}', 'PlayersController@addUserTeam');
Route::patch('/players/{team}/{user}/player', 'PlayersController@setPlayer');
Route::patch('/players/{team}/{user}/denied', 'PlayersController@setDenied');


Route::get('/events' , 'TeamEventsController@all');
Route::post('/events/join/{event}', 'TeamEventsController@join');
Route::delete('/events/{event}/{team}', 'TeamEventsController@removeTeam');

Route::patch('/events/{event}/{team}/accept', 'TeamEventsController@acceptTeam');
Route::patch('/events/{event}/{team}/denied', 'TeamEventsController@deniedTeam');

Route::get('/mail/notif/{team}/{event}', 'MailController@sendemail');








