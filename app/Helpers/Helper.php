<?php

namespace App\Helpers;

use Config;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

use Log;

class Helper{

	public static function isUserLoggedIn(){
		//echo "hhhhhh";
		//echo JWTAuth::parseToken()->authenticate();
		//die();
		try {

			if (! $user = JWTAuth::parseToken()->authenticate()) {
				return false;
			}
			else{
				return $user;
			}
		}
		catch (TokenExpiredException $e) {
			return false;
		}
		catch (TokenInvalidException $e) {
			return false;
		}
		catch (JWTException $e) {
			return false;
		}
		catch (Exception $e) {
			return false;
		}
	}
}