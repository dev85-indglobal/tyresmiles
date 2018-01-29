<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Model\car_name;
use App\Model\car_type;
use Auth;
use Hash;
use Validator;
use App\Http\Controllers\Controller;

class VehicleController extends Controller
{   
    public function list()
    {
      $cars = car_name::all();
      return view('admin/vehicle_list',compact('cars'));
    } 

    public function cars_new()
    {
    	$city = car_name::all();
      $car_types = car_type::all();
      return view('admin/vechicle_new',compact('car_types'));
    }   

    public function cars_view($id)
    {
      $service_data = car_name::where('id',$id)->get();
      $car_types = car_type::all();
      return view('admin/vechicle_view',compact('service_data','car_types'));
    }  
    public function cars_edit(Request $request)
    {

      $check = car_name::where('name',$request->name)->get();

      if (count($check) >0) {
          return redirect('admin/car-types-list')->with('errormsg','Car  name already exists');
        
      }
     $carName = $request->name;
     $type_id = $request->type_id;
     $update = car_name::where('id',$request->id);
                            $update->update(array(
                              'name'=>$carName,
                              'type_id'=>$type_id,
                          ));
      if($update){
       return redirect('admin/cars-list')->with('successmsg','cars detail saved successfully');
      }
      else{
        return redirect('admin/cars-list')->with('errormsg','Something went wrong');
      }
    }   

    public function cars_save(Request $request)
    {

       $check = car_name::where('name',$request->name)->get();

      if (count($check) >0) {
          return redirect('admin/car-types-list')->with('errormsg','Car  name already exists');
        
      }
      $car_name = new car_name();
      $car_name->type_id = $request->type_id;
      $car_name->name = $request->name;
      $car_name->save();
     
       if($car_name){
       return redirect('admin/cars-list')->with('successmsg','New cars saved successfully');
      }
      else{
        return redirect('admin/cars-list')->with('errormsg','Something went wrong');
      }
      
    } 
}
