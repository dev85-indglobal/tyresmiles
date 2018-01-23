<?php

namespace App\Http\Controllers\Api\Service;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ Vendor_detail;

use Validator;

use App\Helpers\Helper;
use App\Helpers\Seekahoo_lib;
use App\User;

use Image;
use Carbon\Carbon;

class ServiceProviderController extends Controller
{
    public function vendor_service_provider(Request $request)
    {  
    	try{
            $serviceName = "vendor_service_provider_store";
            $user = Helper::isUserLoggedIn();
 

            if (!$user || $user->role !=1) {
                $data["message"] = "Unauthorized";
                Seekahoo_lib::return_status('error', $serviceName,$data,'');
                return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
            }

			$validator = Validator::make($request->all(),[
				'vendor_id' => 'required',
				'category_id'  => 'required',
				'vendor_name' =>    'required',
				'address' =>    'required',
				'city_id'     => 'required',
				'logo' => 'required',
				'currency' => 'required',
				'price' => 'required',
				'type' => 'required', // 1-opened, 2-closed.
				
			]);
			
			if ($validator->fails()) {
				$data["message"] = "validation_error";
                $data["errors"]  = $validator->messages()->toJson();
                Seekahoo_lib::return_status('error', $serviceName,$data,'');
                return response()->json(['success' => false, 'error' => 'validation_error', 'message' => $validator->messages()->toJson()], 403);
			}

			$check = Vendor_detail::select('*')->where('vendor_id',$request->vendor_id)->first();

			if ($check) {
				
			$vendors  = Vendor_detail::where('vendor_id',$request->vendor_id);
               $vendors->update(array('category_id' => $request->category_id,
                        'vendor_name' => $request->vendor_name,
                        'address' => $request->address,
                        'city_id' => $request->city_id,
                        'currency' => $request->currency,
                        'price' => $request->price,
                         'type' => $request->type,
                        ));
                 }else{

				$vendor_details          = new Vendor_detail();
				$vendor_details->vendor_id = $request->vendor_id;
				$vendor_details->category_id = $request->category_id;
				$vendor_details->logo ="";
				$vendor_details->logo_thumb ="";
				$vendor_details->vendor_name = $request->vendor_name;
				$vendor_details->address = $request->address;
				$vendor_details->city_id = $request->city_id;
				$vendor_details->currency = $request->currency;
				$vendor_details->type = $request->type;
				$vendor_details->price = $request->price;
				
				$vendor_details->save();

				if($request->hasFile('logo')) {
		            $thumb = $request->logo;
		            $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
		            $filename = $timestamp. '-' .$thumb->getClientOriginalName();
		            $dir = public_path().'/uploads/service_logo_thumb/';
		            if (!file_exists($dir)) {
		                mkdir($dir, 0777, true);
		            }
		            $path = public_path('uploads/service_logo_thumb/' . $filename);
		            $img = Image::make($thumb->getRealPath())->resize(100, 100);
		            $img->save($path);

		            $file = $request->logo;
		            $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
		            $image_path = $timestamp. '-' .$file->getClientOriginalName();
		            $mime_type = $file->getmimeType();
		            $file->move(public_path().'/uploads/logo/', $image_path);

		           $vendor_details   = Vendor_detail::where('vendor_id',$request->vendor_id);
               	   $vendor_details->update(array('logo' => '/uploads/logo/'.$image_path,
                        'logo_thumb'=>'/uploads/service_logo_thumb/'.$filename,
                        ));
		        }
			}
            $data["message"] = "service_provider_details_Successfully Added";
            Seekahoo_lib::return_status('success', $serviceName,$data,'');
			return response()->json(['success' => true,'message' => "service_provider_details_Successfully Added"],200);
		}
		catch(Exception $e){
            $data["message"] = "Something went wrong.<br />Please try again";
            Seekahoo_lib::return_status('error', $serviceName,$data,'');
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
    }


    public function get_vendor_service_providers(Request $request)
    {
    	try{ 
			$serviceName = "get_vendor_details";
            $user = Helper::isUserLoggedIn();

            if (!$user || $user->role != 3) {
                $data["message"] = "Unauthorized";
                Seekahoo_lib::return_status('error', $serviceName,$data,'');
                return response()->json(['success' => false, 'error' => 'auth_error', 'message' => "Unauthorized"], 401);
            }

            $vendor_details = Vendor_detail::all();
        
            $return_arr =array();
            foreach ($vendor_details as $v) {
            	$return_arr[]=array('id'=>$v->id,
                                    'vendor_id'=>$v->vendor_id,
            						'vendor_name'=>$v->vendor_name,
            						'category_id'=>$v->category_id,
            						'logo'=>url($v->logo),
            						'logo_thumb'=>url($v->logo_thumb),
            						'address'=>$v->address,
            						'city_id'=>$v->city_id,
            						'currency'=>$v->currency,
            						'price'=>$v->price,
            						'type'=>$v->type,

            						);
            }

       		$data["message"] = "get_vendor_details";
			Seekahoo_lib::return_status('success', $serviceName,$data,'');
			return response()->json(['success' => true, 'data' => $return_arr, 'message' => 'get_vendor_details'],200);
		}
		catch(Exception $e){
			$data["message"] = "Something went wrong.<br />Please try again";
			Seekahoo_lib::return_status('error', $serviceName,$data,'');
			return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"),500);
		}
    }
}
