<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/
Route::namespace('Api')->group(function () {
    Route::group(['middleware' => ['cors']], function() {
        Route::post('login','CommonController@login');
    });
    Route::middleware('APIToken')->group(function () {
        Route::get('/getprofile','CommonController@getprofile');
        Route::post('/logout','CommonController@logout');
    });
});