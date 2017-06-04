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


Route::group(['prefix' => '/checkin'], function() {
    Route::post('/{id}', 'CheckinController@checkin')
        ->where(['id' => '[0-9]+']);

    Route::get('/status', 'CheckinController@queryCheckin');

    Route::post('/admin/all', 'CheckinController@all');

    Route::post('/admin/reset', 'CheckinController@reset');
});

Route::get('/user_list', 'SelectController@user_list');