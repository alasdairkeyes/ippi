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


Route::get('/ip_ranges',                'IpRangesController@ip_ranges_index');
Route::get('/ip_ranges/{id}',           'IpRangesController@ip_ranges_view');
Route::get('/ip_ranges/add',            'IpRangesController@ip_ranges_add');
Route::post('/ip_ranges/add',           'IpRangesController@ip_ranges_add_post');
Route::get('/ip_ranges/{id}/delete/',   'IpRangesController@ip_ranges_delete');
Route::post('/ip_ranges/{id}/delete/',  'IpRangesController@ip_ranges_delete_post');


Route::get('/ip_owners',                'IpOwnersController@ip_owners_index');
Route::get('/ip_owners/add',            'IpOwnersController@ip_owners_add');
Route::post('/ip_owners/add',           'IpOwnersController@ip_owners_add_post');
Route::get('/ip_owners/{id}/delete/',   'IpOwnersController@ip_owners_delete');
Route::post('/ip_owners/{id}/delete/',  'IpOwnersController@ip_owners_delete_post');
