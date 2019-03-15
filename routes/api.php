<?php


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::any('api', 'Api\ApiController@status');
Route::any('status', 'Api\ApiController@status');



Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', 'Api\AuthController@login');
    Route::post('register', 'Api\AuthController@register');
    Route::post('logout', 'Api\AuthController@logout');
    Route::post('refresh', 'Api\AuthController@refresh');
    Route::post('me', 'Api\AuthController@me');
});


Route::group(['middleware' => 'api', 'prefix' => 'calendarEvents'], function ($router) {
    Route::get('getEvents', 'Api\CalendarEventController@getEvents');
    Route::post('create', 'Api\CalendarEventController@create');
    Route::post('update/{calendar_event_id}', 'Api\CalendarEventController@update');
    Route::post('delete/{calendar_event_id}', 'Api\CalendarEventController@delete');
});