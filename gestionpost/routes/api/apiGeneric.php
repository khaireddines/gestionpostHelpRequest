<?php

use Illuminate\Support\Facades\Route;


//Public generic routes
Route::group(['middleware'=>['api', 'client'],'prefix'=>'v1'],function(){

    Route::resource('/generic/state/select','Generic\DepartamentController')->except(['create','show','edit','update','destroy']);
    Route::resource('/generic/city','Generic\CityController')->except(['index','create','store','edit','update','destroy']);
});

//rutas genericas de admin
Route::group(['middleware'=>['auth:api','admin_user'],'prefix'=>'v1'],function(){

    Route::get('/generic/status/list','Generic\GenericController@StatusListing');
});
