<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Hash;
use URL;
use Validator;
use Carbon\Carbon;
use DB;
use Config;
use Mail;
use Exception;

use App\User;

use App\Helpers\Helper;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use App\Helpers\Seekahoo_lib;

class AppAuthController extends Controller
{
    private $settings;

    /**
     * Instantiate a new AdminDoctorController instance.
     *
     * @return void
     */
    // public function __construct(){
    //  $settings = AdminSettings::all();
    //  $arr = array();
    //  foreach ($settings as $value) {
    //    $arr[$value->key] = $value->value;
    //  }
    //  $this->settings = $arr;
    // }

    public function applogin(Request $request){
        try{
            $serviceName = "login";
            $validator = Validator::make($request->all(),[
                'mobile_no' => 'required',
                'password' => 'required',
                'role' => 'required'
            ]);

            if ($validator->fails()) {
                $data["message"] = "validation_error";
                $data["errors"]  = $validator->messages()->toJson();
                Seekahoo_lib::return_status('error', $serviceName,$data,'');
                return response()->json(['success' => false,'status_code' => 100, 'error' => 'validation_error', 'message' => $validator->messages()->toJson()], 403);
            }

            $mobile_no = $request->mobile_no;
            $password = $request->password;
            $role = $request->role;

            //  $user_type = UserRole::where('id', 3)->first();
         
            $check_user = User::
                          where('mobile_no', $mobile_no)
                          ->where('active', 1)
                          ->where('role', $role)
                          ->first();

            //echo  count($check_user);exit;
   
            if (count($check_user) > 0) {

              $credentials = array(
                  'mobile_no' => $check_user->mobile_no,
                  'password' => $password
                );
            }
            else{
              $data["message"] = "Incorrect Mobile Number/Password";
              Seekahoo_lib::return_status('error', $serviceName,$data,'');
              return response()->json(['success' => false,'status_code' => 100, 'error' => 'invalid_credentials', 'message' => 'Incorrect Mobile Number/Password'], 403);        
            }

            //print_r($credentials);die();
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                  //print_r($credentials);exit;
                  $data["message"] = "Incorrect Mobile Number/Password";
                  Seekahoo_lib::return_status('error', $serviceName,$data,'');
                  return response()->json(['success' => false,'status_code' => 100,'error' => 'invalid_credentials', 'message' => 'Incorrect Mobile Number/Password'], 403);
            }

        }catch (JWTException $e) {
         
            $data["message"] = "Something went wrong. Please try again";
            Seekahoo_lib::return_status('error', $serviceName,$data,'');
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false,'status_code' => 100,'error' => 'could_not_create_token', 'message' => 'Something went wrong. Please try again'], 500);
        }
        //echo "success";
        $data["message"] = "success";
        $data["token"] = $token;
        Seekahoo_lib::return_status('success', $serviceName,$data,'');
        return response()->json(array('success' => true,'status_code' => 200,'data' => $data));
        //return response()->json(compact('token'));
    }

    public function register(Request $request){
        try{

            $serviceName = "register";

            $validator = Validator::make($request->all(),[
              'role' => 'required',
              'email'     => 'required',
              'mobile_no'  => 'required|numeric',
              'password'      => 'required',
              'confirm_password'      => 'required|same:password',
              'name'      => 'required',
            ]);

            if ($validator->fails()) {
                $data["message"] = "validation_error";
                $data["errors"]  = $validator->messages()->toJson();
                Seekahoo_lib::return_status('error', $serviceName,$data,$validator->messages()->toJson());
                return response()->json(['success' => false,'status_code' => 100,'error' => 'validation_error', 'message' => $validator->messages()->toJson()], 403);
            }

            $data = array(
              'role' => $request->role,
              'mobile_no'  => $request->mobile_no,
              'password'  => $request->password,
              'email' =>$request->email,
              'name' =>$request->name,
            );
      
            // Check if email or mobileno already exists
            $email_exists = User::where('email', $data['email'])->where('active', 1)->count();
            $mobile_no_exists = User::where('mobile_no', $data['mobile_no'])->where('active', 1)->count();

            // Check if username or mobileno already exists
            $mobile_no_first_exists = User::where('mobile_no', $data['mobile_no'])->count();
            $email_first_exists = User::where('email', $data['email'])->count();


            $role = $data['role'];
            if ($email_exists > 0 && $mobile_no_exists > 0) {
                $data["message"] = "Email ID and mobile no already exists.<br />Please enter a different mail address and mobile no";
                Seekahoo_lib::return_status('error', $serviceName,$data,'');
                return response()->json(array('success' => false,'status_code' => 100,'error' => 'validation_error', 'message' => "Email ID and mobile no already exists.<br />Please enter a different mail address and mobile no"),402);
            }
            else{
              if ($email_exists > 0) {
                  $data["message"] = "Email ID already exists.<br />Please enter a different mail address";
                  Seekahoo_lib::return_status('error', $serviceName,$data,'');
                  return response()->json(array('success' => false,'status_code' => 100,'error' => 'validation_error', 'message' => "Email ID already exists.<br />Please enter a different mail address"),402);
              }
              if ($mobile_no_exists > 0) {
                  $data["message"] = "Mobile Number already exists.<br />Please enter a different mobile number";
                  Seekahoo_lib::return_status('error', $serviceName,$data,'');
                  return response()->json(array('success' => false,'status_code' => 100,'error' => 'validation_error', 'message' => "Mobile Number already exists.<br />Please enter a different mobile number"),402);
              }
            }
      
            if (!$role) {
                $data["message"] = "Something went wrong.<br />Please try again";
                Seekahoo_lib::return_status('error', $serviceName,$data,'');
                return response()->json(array('success' => false,'status_code' => 100,'error' => 'validation_error', 'message' => "Something went wrong.<br />Please try again"),402);
            }

              try{
                  DB::beginTransaction();
                  $string = '0123456789';
                  $string_shuffled = str_shuffle($string);
                  $otp = substr($string_shuffled, 1, 6);
                  if ($mobile_no_first_exists > 0 && $email_first_exists > 0) {
                      $user_details = array(
                          'role' => $role,
                          'name' => $data['name'],
                          'mobile_no' => $data['mobile_no'],
                          'email' => $data['email'],
                          'password' => bcrypt($data['password']),
                          'otp' => $otp,
                          'active' => 2,
                          'created_at' => Carbon::now()
                        );
                  
                      $User   = User::where('mobile_no',$data['mobile_no']);
                      $User->update($user_details); 
                 }
                 else
                 {
                      $user = new User();
                      $user->email =$data['email'];
                      $user->name =$data['name'];
                      $user->role =$role;
                      $user->mobile_no = $data['mobile_no'];
                      $user->password = bcrypt($data['password']);
                      $user->otp = $otp;
                      $user->active = 2;
                      $user->created_at = Carbon::now();
                      //echo 1234; die();
                      $user->save();
                 }
                 DB::commit();
              }
              catch(Exception $e){
                DB::rollBack();

                $data["message"] = "Something went wrong.<br />Please try again";
                Seekahoo_lib::return_status('error', $serviceName,$data,'');
                return response()->json(['success' => false,'status_code' => 100,'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
              }

              // Send SMS
              $msgtxt = "Your otp is ". $otp .". Otp will expire within 15 minutes :TyreSmiles";  

              $msgData = array(
                'recipient_no' => $request->mobile_no,
                'msgtxt' => $msgtxt
              );
              //$sendsms = Helper::sendSMS($msgData);
     
              //send mail

               // $mailtxt = "Your otp is ". $otp .". Otp will expire within 15 minutes";  

                  // $msgData = array(
                  //   'recipient_email' => $request->email,
                  //   'mailtxt' => $mailtxt
                  // );

                  // Mail::send('emails.welcomeuser', ['mailtxt' => $mailtxt], function ($message) use ($data)
                  // {
                  //   $message->to($data['email']);
                  //   $message->subject('Welcome To TyreSmiles');
                   
                  // }); 
      
              $data["message"] = "Otp Sent Successfully.";
              Seekahoo_lib::return_status('success', $serviceName,$data,'');
              return response()->json(array('success' => true,'status_code' => 200,'message' => 'Otp Sent Successfully.'));
        }
        catch(Exception $e){
            $data["message"] = "Something went wrong.<br />Please try again.";
            Seekahoo_lib::return_status('error', $serviceName,$data,'');
            return response()->json(array('success' => false,'status_code' => 100,'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again", 'data' => $e->getMessage()),402);
        }
    }

    public function resend_otp(Request $request){
        try{
            $serviceName = "resend_code";
            $validator = Validator::make($request->all(),[
              'mobile_no'  => 'required|numeric',
            ]);

            if ($validator->fails()) {
              $data["message"] = "validation_error";
              $data["errors"]  = $validator->messages()->toJson();
              Seekahoo_lib::return_status('error', $serviceName,$data,$validator->messages()->toJson());
              return response()->json(['success' => false,'status_code' => 100,'error' => 'validation_error', 'message' => $validator->messages()->toJson()], 403);
            }

            $data = array(
              'mobile_no'  => $request->mobile_no,
            );
        
    $mobile_no_exists = User::where('mobile_no', $data['mobile_no'])->where('active', 2)->count();
            if ($mobile_no_exists == 0) {
                  $data["message"] = "Mobile Number doesn't exist.<br />Please enter a valid mobile number";
                  Seekahoo_lib::return_status('error', $serviceName,$data,'');
                  return response()->json(array('success' => false,'status_code' => 100,'error' => 'validation_error', 'message' => "Mobile Number doesn't exists.<br />Please enter a different mobile number"),402);
            }
            $string = '0123456789';
            $string_shuffled = str_shuffle($string);
            $otp = substr($string_shuffled, 1, 6);

            // Send SMS
            $msgtxt = "Your otp is ". $otp .". Otp will expire within 15 minutes :TyreSmiles";

            $msgData = array(
              'recipient_no' => $request->mobile_no,
              'msgtxt' => $msgtxt
            );
            //$sendsms = Helper::sendSMS($msgData);

            $data["message"] = "Otp Resent Successfully";
            Seekahoo_lib::return_status('success', $serviceName,$data,'');
            return response()->json(array('success' => true,'status_code' => 200,'message' => 'Otp Resent Successfully.'));
        }
        catch(Exception $e){
            $data["message"] = "Something went wrong.<br />Please try again.";
            Seekahoo_lib::return_status('error', $serviceName,$data,'');
            return response()->json(array('success' => false,'status_code' => 100,'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again", 'data' => $e->getMessage()),402);
        }
    }

    public function confirm_otp(Request $request){
        try{
            $serviceName = "confirm_otp";
            $validator = Validator::make($request->all(),[
              'mobile_no'  => 'required|numeric',
              'otp'  => 'required|numeric',
              'password'=>'required',
            ]);

            if ($validator->fails()) {
              $data["message"] = "validation_error";
              $data["errors"]  = $validator->messages()->toJson();
              Seekahoo_lib::return_status('error', $serviceName,$data,$validator->messages()->toJson());
              return response()->json(['success' => false,'status_code' => 100,'error' => 'validation_error', 'message' => $validator->messages()->toJson()], 403);
            }

            /*Check Invalid Otp*/
            $invalid = User::where('otp', $request['otp'])->where('mobile_no', $request['mobile_no'])->count();
      
            if(!$invalid)
            {
                $data["message"] = "Invalid Otp!";
                Seekahoo_lib::return_status('success', $serviceName,$data,'');    
                return response()->json(array('success' => false,'status_code' => 100,'error' => 'server_error', 'message' => "Invalid Otp!", 'data' => $data["message"] ),400);
            }
     
            /*Check User Already Exists*/
            $user_exists = User::where('otp', $request['otp'])->where('mobile_no', $request['mobile_no'])->where('active', 1)->count();

            if($user_exists)
            {
                $data["message"] = "User Already Registered!";
                Seekahoo_lib::return_status('success', $serviceName,$data,'');    
                return response()->json(array('success' => false,'status_code' => 100,'error' => 'server_error', 'message' => "User Already Registered!", 'data' => $data["message"] ),400);
            }

            /*Check Expired Otp*/
            // $expired = User::where('otp', $request['otp'])->where('mobile_no', $request['mobile_no'])->whereRaw("created_at BETWEEN now() - interval 15 minute AND now()")->count();

            //   if(!$expired)
            //   {
            // $data["message"] = "Otp Expired!";
            // Seekahoo_lib::return_status('success', $serviceName,$data,'');    return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Otp Expired!", 'data' => $data["message"] ),'400');
            //   }

            //for login 
            $credentials = array(
                  'mobile_no' => $request['mobile_no'],
                  'password' => $request['password'],
            );

            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                  $data["message"] = "Incorrect Mobile Number/Password";
                  Seekahoo_lib::return_status('error', $serviceName,$data,'');
                  return response()->json(['success' => false,'status_code' => 100,'error' => 'invalid_credentials', 'message' => 'Incorrect Mobile Number/Password'], 403);
            }

            $user_details = array(
              'active' => 1,
            );
            
            $User   = User::where('mobile_no',$request['mobile_no']);
            $User->update($user_details); 

            // Send SMS
            $msgtxt = "Registration Completed Successfully :TyreSmiles.";

            $msgData = array(
              'recipient_no' => $request->mobile_no,
              'msgtxt' => $msgtxt
            );
            //$sendsms = Helper::sendSMS($msgData);

            
            $data["token"] = $token;
            $data["message"] = "Registered Successfully.";
            Seekahoo_lib::return_status('success', $serviceName,$data,'');
            return response()->json(array('success' => true,'status_code' => 200,'data' => $data));
        }
        catch(Exception $e){
          $data["message"] = "Something went wrong.<br />Please try again.";
          Seekahoo_lib::return_status('error', $serviceName,$data,'');
          return response()->json(array('success' => false,'status_code' => 100,'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again", 'data' => $e->getMessage()),400);
        }
    }

    public function logout(){
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
              return response()->json(['user_not_found'], 404);
            }
        }
        catch (TokenExpiredException $e) {
          return response()->json(['token_expired'], 500);
        }
        catch (TokenInvalidException $e) {
          return response()->json(['token_invalid'], 500);
        }
        catch (JWTException $e) {
          return response()->json(['token_absent'], 500);
        }
        catch (Exception $e) {
          return response()->json(['server_error'], 500);
        }

        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(array('success' => true,'status_code' => 200,'message' => "Logout Successfully "));
    }

    public function forgotPassword(Request $request)
    {
        try{
              $serviceName = "forget_password";
              $validator = Validator::make($request->all(),[
                'mobile_no'  => 'required|numeric',               
              ]);

              if ($validator->fails()) {
                  $data["message"] = "validation_error";
                  $data["errors"]  = $validator->messages()->toJson();
                  Seekahoo_lib::return_status('error', $serviceName,$data,$validator->messages()->toJson());
                  return response()->json(['success' => false,'status_code' => 100,'error' => 'validation_error', 'message' => $validator->messages()->toJson()], 403);
              }

              $data = array(
                'mobile_no'  => $request->mobile_no
              );

              if ($request->has('mobile_no')) {
                  $mobile_no = $request->mobile_no;
                                    
                  $user = User::where('mobile_no',  $mobile_no)
                            ->first();
                    
                  if ($user != NULL && $user->active == 1) 
                  {
                      $string = '0123456789';
                      $string_shuffled = str_shuffle($string);
                      $otp = substr($string_shuffled, 1, 6);

                      $forget_password = User::where('user_id', $user->user_id);
                      $forget_password->update(array(
                                            'otp' => $otp));
                      if( $forget_password )
                      {
                          // Send SMS
                          $msgtxt = "Your otp is ". $otp .". Otp will expire within 15 minutes";

                          $msgData = array(
                            'recipient_no' => $request->mobile_no,
                            'msgtxt' => $msgtxt
                          );

                          //$sendsms = Helper::sendSMS($msgData);
                          if( $sendsms){
                          $data["message"] = "Otp sent Successfully";
                          Seekahoo_lib::return_status('success', $serviceName,$data,'');
                          return response()->json(array('success' => true,'status_code' => 200,'message' => 'Otp sent Successfully.'));
                      }
                      else
                      {
                          $data["message"] = "Unable to send OTP.";
                          Seekahoo_lib::return_status('error', $serviceName,$data,'');
                          return response()->json(array('success' => false,'status_code' => 100,'error' => 'server_error', 'message' =>  $data["message"], 'data' =>  $data["message"]),402);
                      }
                  }
                  else
                  {
                      $data["message"] = "Unable to send OTP.";
                      Seekahoo_lib::return_status('error', $serviceName,$data,'');
                      return response()->json(array('success' => false,'status_code' => 100,'error' => 'server_error', 'message' =>  $data["message"], 'data' =>  $data["message"]),402);
                  }
              }else
              {
                  $data["message"] = "Invalid User Credentials.";
                  Seekahoo_lib::return_status('error', $serviceName,$data,'');
                  return response()->json(array('success' => false,'status_code' => 100,'error' => 'server_error', 'message' =>  $data["message"], 'data' =>  $data["message"]),402);
              }
       
            }
          }
          catch(Exception $e){
              $data["message"] = "Something went wrong.<br />Please try again.";
              Seekahoo_lib::return_status('error', $serviceName,$data,'');
              return response()->json(array('success' => false,'status_code' => 100,'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again", 'data' => $e->getMessage()),402);
          }
    }

    public function confirm_forget_password_otp(Request $request){
        try{
            $serviceName = "confirm_forget_password_otp";
            $validator = Validator::make($request->all(),[
                'mobile_no'  => 'required|numeric',
                'otp'  => 'required|numeric',
                'new_password'  => 'required',
                'confirm_password'  =>'required|same:new_password',
            ]);

            if ($validator->fails()) {
              $data["message"] = "validation_error";
              $data["errors"]  = $validator->messages()->toJson();
              Seekahoo_lib::return_status('error', $serviceName,$data,$validator->messages()->toJson());
              return response()->json(['success' => false,'status_code' => 100,'error' => 'validation_error', 'message' => $validator->messages()->toJson()], 403);
            }

            /*Check Invalid Otp*/
            $invalid = User::where('otp', $request['otp'])->where('mobile_no', $request['mobile_no'])->count();
      
            if(!$invalid)
            {
                $data["message"] = "Invalid Otp!";
                Seekahoo_lib::return_status('success', $serviceName,$data,'');    
                return response()->json(array('success' => false,'status_code' => 100,'error' => 'server_error', 'message' => "Invalid Otp!", 'data' => $data["message"] ),400);
            }
        
            $data = array(
                'mobile_no'  => $request->mobile_no
            );

            if ($request->has('mobile_no')) {
              $mobile_no = $request->mobile_no;                           
              $user = User::where('mobile_no',  $mobile_no)
                        ->first();
            }

            if ($user != NULL && $user->active == 1) 
            {
                $user   = User::where('id',$user->id);
                $user->update(array('password' => bcrypt($request->confirm_password)));

               
                if($user){
                        $data["message"] = "Password Changed Successfully";
                        Seekahoo_lib::return_status('success', $serviceName,$data,'');
                        return response()->json(['success' => true,'status_code' => 200,'message' => 'Password Changed Successfully']);
                } else{
                        $data["message"] = "Something Went Wrong!";
                        Seekahoo_lib::return_status('error', $serviceName,$data,'');
                        return response()->json(['success' => false,'status_code' => 100,'message' => 'Something Went Wrong!'], 403);
                }
            }

            $user_details = array(
                  'active' => 1,
                );
            $User   = User::where('mobile_no',$request['mobile_no']);
            $User->update($user_details); 

            // Send SMS
            $msgtxt = "password changed Successfully.";

            $msgData = array(
              'recipient_no' => $request->mobile_no,
              'msgtxt' => $msgtxt
            );
           // $sendsms = Helper::sendSMS($msgData);

            $data["message"] = "password changed Successfully.";
            Seekahoo_lib::return_status('success', $serviceName,$data,'');
            return response()->json(array('success' => true,'status_code' => 200,'message' => $data["message"]));
        }
        catch(Exception $e){
            $data["message"] = "Something went wrong.<br />Please try again.";
            Seekahoo_lib::return_status('error', $serviceName,$data,'');
            return response()->json(array('success' => false,'status_code' => 100,'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again", 'data' => $e->getMessage()),400);
        }
    }

}
