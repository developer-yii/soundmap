<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return redirect(route('dashboard'));
// });
Auth::routes();

Route::group(['prefix' => 'location'], function () {
		Route::get('/', 'LocationController@index')->name('location');
		Route::get('/index', 'LocationController@index')->name('location');
		Route::get('/get', 'LocationController@getlocationdetails')->name('location.list');
		Route::get('/create', 'LocationController@viewlocation')->name('location.viewlocation');
		Route::post('/add', 'LocationController@add')->name('location.add');
		Route::get('/edit', 'LocationController@edit')->name('location.edit');	
		Route::post('update', 'LocationController@update')->name('location.update');	
		Route::post('/delete', 'LocationController@delete')->name('location.delete');
       	Route::POST('/imagedelete/{id}','LocationController@deleteimage')->name('location.deleteimage');
       	Route::post('/deletevideo/{id}','LocationController@deletevideo')->name('location.deletevideo');
       	Route::post('/deleteaudio/{id}','LocationController@deleteaudio')->name('location.deleteaudio');
	});

Route::get('/', 'DashboardController@index')->name('dashboard');
Route::get('/index', 'DashboardController@index')->name('dashboard');
Route::get('/getDetail', 'DashboardController@getLocationDetail')->name('dashboard.location.detail');

Route::get('/map', 'SiteController@map')->name('map');
Route::get('/detail', 'SiteController@detail')->name('map.detail');


Route::middleware(['auth'])->group(function () {
	Route::get('/home', 'HomeController@index')->name('home');	
});