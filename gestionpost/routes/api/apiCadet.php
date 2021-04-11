<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['auth:api','cadet_user'],'prefix'=>'v1'],function(){

});
