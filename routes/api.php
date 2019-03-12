<?php

Route::get('services', 'ServicesController@index');
Route::get('services/{id}', 'ServicesController@show');
Route::post('login', 'AuthController@login');

Route::middleware('auth:api')->group(function () {
    Route::post('services', 'ServicesController@store');
    Route::put('services/{id}', 'ServicesController@update');
    Route::delete('services/{id}', 'ServicesController@destroy');
});
