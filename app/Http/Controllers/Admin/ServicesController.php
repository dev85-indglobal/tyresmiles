<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Model\Master_service_categories;
use Auth;
use Hash;
use Validator;
use App\Http\Controllers\Controller;

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
      $inserted = $service->save();
      if($inserted){
       return redirect('admin/services-list')->with('successmsg','Your details saved successfully');
      }
      else{
        return redirect('admin/services-list')->with('errormsg','Something went wrong');
      }
    }     
}
