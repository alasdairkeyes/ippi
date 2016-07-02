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


Route::get('/ip_ranges',                'IpRangesController@ipRangesIndex');
Route::get('/ip_ranges/add',            'IpRangesController@ipRangesAdd');
Route::post('/ip_ranges/add',           'IpRangesController@ipRangesAddPost');
Route::get('/ip_ranges/{id}',           'IpRangesController@ipRangesView');
Route::get('/ip_ranges/{id}/delete/',   'IpRangesController@ipRangesDelete');
Route::post('/ip_ranges/{id}/delete/',  'IpRangesController@ipRangesDeletePost');


Route::get('/ip_ranges/{id}/{ip_address}',  'IpRangesController@ipRangesIpAddressView');
Route::post('/ip_ranges/{id}/{ip_address}', 'IpRangesController@ipRangesIpAddressViewPost');

Route::get('/ip_ranges/{id}/{ip_address}/delete',  'IpRangesController@ipRangesIpAddressDelete');
Route::post('/ip_ranges/{id}/{ip_address}/delete',  'IpRangesController@ipRangesIpAddressDeletePost');

Route::get('/ip_owners',                'IpOwnersController@ipOwnersIndex');
Route::get('/ip_owners/add',            'IpOwnersController@ipOwnersAdd');
Route::post('/ip_owners/add',           'IpOwnersController@ipOwnersAddPost');
Route::get('/ip_owners/{id}/delete/',   'IpOwnersController@ipOwnersDelete');
Route::post('/ip_owners/{id}/delete/',  'IpOwnersController@ipOwnersDeletePost');
