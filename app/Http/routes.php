<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::auth();

Route::get('/', 'HomeController@index');


Route::get('/ip_ranges', 'IpRangesController@ip_ranges_index');
Route::get('/ip_owners', 'IpOwnersController@ip_owners_index');
