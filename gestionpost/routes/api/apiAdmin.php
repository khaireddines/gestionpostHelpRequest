<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['auth:api','admin_user'],'prefix'=>'v1'],function(){

    //Monedas
    Route::get('/admin/currency/list','Admin\CurrencyController@ListCurrencies');
    Route::get('/admin/currency/add','Admin\CurrencyController@Add');
    Route::get('/admin/currency/edit/{id}','Admin\CurrencyController@edit');
    Route::post('/admin/currency/insert','Admin\CurrencyController@insert');
    Route::post('/admin/currency/update','Admin\CurrencyController@update');

    //States
    Route::get('/admin/states/list','Admin\StateController@ListStates');
    Route::get('/admin/states/edit/{id}','Admin\StateController@edit');
    Route::post('/admin/states/insert','Admin\StateController@insert');
    Route::post('/admin/states/update','Admin\StateController@update');
    Route::get('/admin/states/delete/{id}','Admin\StateController@delete');


    //status
    Route::get('/admin/status/list','Generic\StateController@getStatusAll');
    Route::get('/admin/status/list/order/{id}','Generic\StateController@getStatusId');

    //Departamentos
    Route::get('/admin/state/list','Admin\StateController@ListStates');
    Route::get('/admin/state/edit/{id}','Admin\StateController@edit');
    Route::post('/admin/state/insert','Admin\StateController@insert');
    Route::post('/admin/state/update','Admin\StateController@update');
    Route::post('/admin/state/delete/{id}','Admin\StateController@delete');
    Route::get('/admin/sate/select/all','Admin\StateController@selectDepartament');


    //City
    Route::get('/admin/city/list/{id}','Admin\CityController@listCity');
    Route::get('/admin/city/add','Admin\CityController@add');
    Route::get('/admin/city/edit/{id}','Admin\CityController@edit');
    Route::post('/admin/city/insert','Admin\CityController@insert');
    Route::post('/admin/city/update','Admin\CityController@update');
    Route::get('/admin/city/select/{id_departament}','Admin\CityController@selectOptionAllCity');

    //Neighborhood
    Route::get('/admin/neighborhood/list/{id_city}','Admin\NeighborhoodController@listNeighborhood');
    Route::get('/admin/neighborhood/add','Admin\NeighborhoodController@add');
    Route::get('/admin/neighborhood/edit/{id}', 'Admin\NeighborhoodController@edit');
    Route::post('/admin/neighborhood/insert','Admin\NeighborhoodController@insert');
    Route::post('/admin/neighborhood/update','Admin\NeighborhoodController@update');



    //Business
    Route::resource('/business','Business\BusinessController');



});
