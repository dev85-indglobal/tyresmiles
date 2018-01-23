<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
date_default_timezone_set('Asia/Kolkata');
Route::group(['middleware' => 'cors', 'prefix' => '/v1'], function () {
	  Route::post('authenticate/register', 'AppAuthController@register');
	  Route::post('authenticate/resend_otp', 'AppAuthController@resend_otp');
	  Route::post('authenticate/confirm_otp', 'AppAuthController@confirm_otp');
	  Route::post('authenticate/forget_password', 'AppAuthController@forgotPassword');
      Route::post('authenticate/confirm_forget_password_otp', 'AppAuthController@confirm_forget_password_otp');
      Route::post('authenticate/login', 'AppAuthController@applogin');


      //Master Details 
    Route::get('get_master_service_categories','Api\Master\MasterController@get_Master_service_categories');
    Route::get('get_master_car_types','Api\Master\MasterController@get_master_car_types');
    Route::get('get_master_cars','Api\Master\MasterController@get_master_cars');
    Route::get('get_master_basic_car_wash','Api\Master\MasterController@get_master_basic_car_wash');
    Route::get('get_master_full_car_wash','Api\Master\MasterController@get_master_full_car_wash');
    Route::get('get_two_d_wheel_allignment','Api\Master\MasterController@get_two_d_wheel_allignment');
    Route::get('get_three_d_wheel_allignment_package','Api\Master\MasterController@get_three_d_wheel_allignment_package');
    Route::get('get_three_d_wheel_allignment','Api\Master\MasterController@get_three_d_wheel_allignment');
    Route::get('get_master_city','Api\Master\MasterController@get_master_city');

    //media
    Route::post('service_category_media_upload','Api\Media\MediaController@service_category_media_store');

    //vendor_service_provider
    Route::post('vendor_service_provider','Api\Service\ServiceProviderController@vendor_service_provider');
    Route::get('get_vendor_service_provider','Api\Service\ServiceProviderController@get_vendor_service_providers');

   //search
    Route::get('search','Api\Search\SearchVendorsController@search');


});