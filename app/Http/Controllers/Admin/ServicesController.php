<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Model\Master_service_categories;
use Auth;
use Hash;
use Validator;
use App\Http\Controllers\Controller;
use App\Model\media;
use Carbon\Carbon;
use Image;

class ServicesController extends Controller
{   
    public function list()
    {
      $services = Master_service_categories::all();
      return view('admin/services_list',compact('services'));
    } 
    public function service_view($id)
    {
      $service_data = Master_service_categories::where('id',$id)->get();
      return view('admin/service_view',compact('service_data'));
    }  
    public function service_edit(Request $request)
    {
      $serviceId = $request->service_id;
      $serviceName = $request->service_name;
      $stat = $request->service_active;
      $update = Master_service_categories::where('id',$serviceId)
                                          ->update(['name'=>$serviceName,'active'=>$stat]);
      if($update){
       return redirect('admin/services-list')->with('successmsg','Your details saved successfully');
      }
      else{
        return redirect('admin/services-list')->with('errormsg','Something went wrong');
      }
    } 
    public function service_new()
    {
      return view('admin/service_new');
    }   
    public function service_save(Request $request)
    {
      $service = new Master_service_categories();
      $service->name = $request->service_name;
      $service->active = $request->service_active;
      $service->save();
     
      if($request->hasFile('service_Img')) {

      
      $thumb = $request->service_Img;
      $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
      $filename = $timestamp. '-' .$thumb->getClientOriginalName();
      $dir = public_path().'/uploads/media_thumb/';
      if (!file_exists($dir)) {
          mkdir($dir, 0777, true);
      }
            $path = public_path('uploads/media_thumb/' . $filename);
      $img = Image::make($thumb->getRealPath())->resize(100, 100);
      $img->save($path);

      $file = $request->service_Img;
      $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
      $image_path = $timestamp. '-' .$file->getClientOriginalName();
      $mime_type = $file->getmimeType();
      $file->move(public_path().'/uploads/media/', $image_path);

      $media           = new media();
      
      $media->category_id = $service->id;
      $media->media_image    = '/uploads/media/'.$image_path;
      $media->media_image_thumb    = '/uploads/media_thumb/'.$filename;
      $success = $media->save();

      if($success){
       return redirect('admin/services-list')->with('successmsg','Your details saved successfully');
      }
      else{
        return redirect('admin/services-list')->with('errormsg','Something went wrong');
      }
      
      
    } 
  }
        
}
