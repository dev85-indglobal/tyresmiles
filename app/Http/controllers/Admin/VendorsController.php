<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Model\Master_service_categories;
use App\Model\Vendor_detail;
use App\Model\city;

use Auth;
use Hash;
use Validator;
use App\Http\Controllers\Controller;
use App\Model\media;
use Carbon\Carbon;
use Image;

class VendorsController extends Controller
{


	 public function list()
    {
      $details = Vendor_detail::all();
      return view('admin/vendors_list',compact('details'));
    } 


	public function vendors_new()
    {
    	$city = city::where('state_id',17)->get();
      return view('admin/vendors_new',compact('city'));
    }   

     public function vendors_view($id)
    {
      $city = city::where('state_id',17)->get();
      $vendors_data =Vendor_detail::where('id',$id)->get();
      return view('admin/vendor_view',compact('vendors_data','city'));
    }  

    public function vendors_edit(Request $request)
    {

       $category_id = $request->category_id;
       $vendor_name = $request->vendor_name;
       $address = $request->address;
       $city_id = $request->city_id;
       $logo = $request->logo;
       $currency = $request->currency;
       $price = $request->price;
       $type = $request->type;
      $update = Vendor_detail::where('id',$request->vendor_id);
                            $update->update(array('category_id'=>$category_id,
                              'vendor_name'=>$vendor_name,
                              'address'=>$address,
                              'city_id'=>$city_id,
                              'logo'=>"",
                              'currency'=>$currency,
                              'price'=>$price,
                              'type'=> $type,
                               ));
			
			if($request->hasFile('logo')) {
		            $thumb = $request->logo;
		            $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
		            $filename = $timestamp. '-' .$thumb->getClientOriginalName();
		            $dir = public_path().'/uploads/vendors_logo_thumb/';
		            if (!file_exists($dir)) {
		                mkdir($dir, 0777, true);
		            }
		            $path = public_path('uploads/vendors_logo_thumb/' . $filename);
		            $img = Image::make($thumb->getRealPath())->resize(100, 100);
		            $img->save($path);

		            $file = $request->logo;
		            $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
		            $image_path = $timestamp. '-' .$file->getClientOriginalName();
		            $mime_type = $file->getmimeType();
		            $file->move(public_path().'/uploads/logo/', $image_path);

		           $update   = Vendor_detail::where('id',$request->vendor_id);
               	  $success = $update->update(array('logo' => '/uploads/logo/'.$image_path,
                        'logo_thumb'=>'/uploads/vendors_logo_thumb/'.$filename,
                      ));   
                  }

               	
      if($success){
       return redirect('admin/vendors-list')->with('successmsg','vendor details saved successfully');
      }
      else{
        return redirect('admin/vendors-list')->with('errormsg','Something went wrong');
      }
    } 


    public function vendors_save(Request $request)
    {

    	
			$validator = Validator::make($request->all(),[
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
		 return redirect('admin/vendors_list')
					->withErrors($validator)
					->withInput();
		}

				$vendor_details          = new Vendor_detail();
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
                 $vendor_id = $vendor_details->id;
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

		           $vendor_details   = Vendor_detail::where('id',$vendor_id);
               	  $success = $vendor_details->update(array('logo' => '/uploads/logo/'.$image_path,
                        'logo_thumb'=>'/uploads/service_logo_thumb/'.$filename,
                        ));
		        }
			
     
         if($success){
       return redirect('admin/vendors-list')->with('successmsg','Your details saved successfully');
      }
      else{
        return redirect('admin/vendors-list')->with('errormsg','Something went wrong');
      }

    }


}
