<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//Route::auth();



Route::group(['middleware' => 'web'], function()
{
    Route::get('/c/{company_id}/l/{location_id}/m/{monitor_id}/p/{parameter}',

        'IndexController@index');
    Route::get('/c/{company_id}',

        'CompanyController@companyData');
    Route::any('/Service/Company','ServiceController@getCompany');
    Route::any('/Service/Location','ServiceController@getLocation');
    Route::any('/Service/Monitors','ServiceController@getMonitors');
    Route::any('/Service/Latest','ServiceController@getLatest');

    Route::get('/Refresh','RefreshController@refresh');
    Route::get('/','IndexController@index');



});

// API 相关
Route::group(['prefix' => 'api', 'namespace' => 'Api' ,'middleware' => 'web'], function(){
    Route::any('router', 'RouterController@index');  // API 入口
});

