<?php

Route::get('services', 'ServicesController@index');


Route::middleware('auth:api')->group(function () {
    Route::post('services', 'ServicesController@store');
    Route::put('services/{id}', 'ServicesController@update');
});
