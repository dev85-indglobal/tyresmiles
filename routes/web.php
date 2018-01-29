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
	
	Route::get('service-view/{id}','Admin\ServicesController@service_view');
	Route::post('service-edit','Admin\ServicesController@service_edit');
	Route::get('service-new','Admin\ServicesController@service_new');
	Route::post('service-save','Admin\ServicesController@service_save');

	//vendor routes
	Route::get('vendors-new','Admin\VendorsController@vendors_new');
	Route::post('vendors-save','Admin\VendorsController@vendors_save');
	Route::get('vendors-list','Admin\VendorsController@list');
	Route::post('vendors-edit','Admin\VendorsController@vendors_edit');
	Route::get('vendor-view/{id}','Admin\VendorsController@vendors_view');
	
	//cars_name
	Route::get('cars-list','Admin\VehicleController@list');
	Route::post('cars-save','Admin\VehicleController@cars_save');
	Route::get('cars-new','Admin\VehicleController@cars_new');
	Route::post('cars-edit','Admin\VehicleController@cars_edit');
	Route::get('cars-view/{id}','Admin\VehicleController@cars_view');
	
	//car_types
	Route::get('car-types-list','Admin\CarTypesController@list');
	Route::post('car-types-save','Admin\CarTypesController@cars_types_save');
	Route::get('car-types-new','Admin\CarTypesController@cars_types_new');
	Route::post('car-types-edit','Admin\CarTypesController@cars_types_edit');
	Route::get('car-types-view/{id}','Admin\CarTypesController@cars_types_view');
	
	//service_sub_categories
	Route::get('service-sub-categories-list','Admin\ServiceSubCategoriesController@list');
	Route::post('service-sub-categories-save','Admin\ServiceSubCategoriesController@service_sub_categories_save');
	Route::get('service-sub-categories-new','Admin\ServiceSubCategoriesController@service_sub_categories_new');
	Route::post('service-sub-categories-edit','Admin\ServiceSubCategoriesController@service_sub_categories_edit');
	Route::get('service-sub-categories-view/{id}','Admin\ServiceSubCategoriesController@service_sub_categories_view');

});

