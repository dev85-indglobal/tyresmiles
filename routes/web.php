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

Route::get('/admin','Admin\AdminLoginController@adminLogin');
Route::post('/admin','Admin\AdminLoginController@postAdminLogin');
Route::get('/adminlogout','Admin\AdminLoginController@adminLogout');
Route::group(['prefix' => 'admin','middleware' => 'isadmin'], function(){
	Route::get('dashboard','Admin\AdminLoginController@dashboard');
	Route::get('services-list','Admin\ServicesController@list');
});
