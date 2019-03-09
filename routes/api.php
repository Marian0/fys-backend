<?php

use Illuminate\Http\Request;

Route::get('services', 'ServicesController@index');


Route::middleware('auth:api')->group(function(){
//    Route::post('services', 'ServicesController@create');
});
