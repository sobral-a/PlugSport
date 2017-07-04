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

//Route::get('/eventsAdmin', 'EventsController@events');
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

Route::post('/search', 'TeamEventsController@filter');

Route::patch('/events/{event}/{team}/accept', 'TeamEventsController@acceptTeam');
Route::patch('/events/{event}/{team}/denied', 'TeamEventsController@deniedTeam');

Route::post('/mail/notif/{team}/{event}', 'MailController@sendemail');
Route::get('/profile' , 'ProfileController@profile');
Route::post('/profile/rappel' , 'ProfileController@updateRappel');
Route::post('/profile/update', 'ProfileController@update');
Route::get('/profile/public/{user}', 'ProfileController@showPublic');

Route::get('/availability', 'AvailabilitiesController@availability');
Route::post('/availability/{team}/{event}', 'AvailabilitiesController@checkTeamAvailability');
Route::get('/availability/player', 'AvailabilitiesController@playerAvailabilities');
Route::patch('/availability/{av}/av', 'AvailabilitiesController@setAvailable');
Route::patch('/availability/{av}/unav', 'AvailabilitiesController@setUnavailable');
Route::delete('/availability/{av}/delete', 'AvailabilitiesController@delete');




