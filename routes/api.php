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
});