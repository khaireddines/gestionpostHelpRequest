<?php

use Illuminate\Support\Facades\Route;


Route::group(['middleware'=>['api','client'],'prefix'=>'v1'],function(){

    Route::resource('business','Business\BusinessController')->except(['index','show','edit','update','destroy']);
    Route::resource('accountBusiness','Auth\BusinessAccountController')->except(['index','create','show','edit','update','destroy']);


});


Route::group(['middleware'=>['auth:api','company_user'],'prefix'=>'v1'],function(){



});
