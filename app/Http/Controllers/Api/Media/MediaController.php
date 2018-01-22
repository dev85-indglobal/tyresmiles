<?php

namespace App\Http\Controllers\Api\Media;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ media;

use Validator;

use App\Helpers\Helper;
use App\Helpers\Seekahoo_lib;
use App\User;

use Image;
use Carbon\Carbon;

class MediaController extends Controller
{
    public function service_category_media_store(Request $request)
    {
    	try{
    		$serviceName = "category_media_store";
           
            
			$validator = Validator::make($request->all(),[
				'category_id'=>'required',
				'media_image'=>'required'
			]);

			if ($validator->fails()) {
				$data["message"] = "validation_error";
				$data["errors"]  = $validator->messages()->toJson();
                Seekahoo_lib::return_status('error', $serviceName,$data,'');
                return response()->json(['success' => false, 'error' => 'validation_error', 'message' => $validator->messages()->toJson()], 403);
			}

			$records = new media(); 
			$records->category_id= $request->category_id;
			
			if($request->hasFile('media_image')){
		            $thumb = $request->media_image;
		            $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
		            $filename = $timestamp. '-' .$thumb->getClientOriginalName();
		            $dir = public_path().'/uploads/media_record_thumb/';
		            if (!file_exists($dir)) {
		                mkdir($dir, 0777, true);
		            }
		            $path = public_path('uploads/media_record_thumb/' . $filename);
		            $img = Image::make($thumb->getRealPath())->resize(100, 100);
		            $img->save($path);

		            $file = $request->media_image;
		            $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
		            $image_path = $timestamp. '-' .$file->getClientOriginalName();
		            $mime_type = $file->getmimeType();
		            $file->move(public_path().'/uploads/media_record/', $image_path);

                    $records->media_image = '/uploads/media/'.$image_path;
                    $records->media_image_thumb = '/uploads/media_record_thumb/'.$filename;
		    }

		    $records->save();

		    $data["message"] = "service category media images Added Successfully";
			Seekahoo_lib::return_status('success', $serviceName,$data,'');
			return response()->json(['success' => true,'message' => "service category media images Added Successfully"],200);
		}
		catch(Exception $e){
			$data["message"] = "Something went wrong.<br />Please try again";
			Seekahoo_lib::return_status('error', $serviceName,$data,'');
			return response()->json(['success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"], 500);
		}
    }
}
