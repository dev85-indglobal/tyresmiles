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
	public static function sendSMS($data){
        try{
            	$receipientno =  $data['recipient_no'];
                $msgtxt = $data['msgtxt'];

                if (!$receipientno || $receipientno == '' || !$msgtxt || $msgtxt == '') {
                    return false;
                }
                $message = urlencode($msgtxt);
                
                $ch=curl_init();
                curl_setopt($ch,CURLOPT_URL,"http://smsapi.24x7sms.com/api_2.0/SendSMS.aspx?APIKEY=G7SpdPXYh5O&MobileNo=$receipientno&SenderID=TESTIN&Message=$message&ServiceName=TEMPLATE_BASED");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                $buffer =curl_exec($ch);
                curl_close($ch);


                                if (empty($buffer)) {
                                    return false;
                                }

                                Log::info($buffer);

                                return $buffer;
        }catch(Exception $e){
            return false;
        }       
    }
}