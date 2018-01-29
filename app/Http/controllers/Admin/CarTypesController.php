<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Model\car_name;
use App\Model\car_type;
use Auth;
use Hash;
use Validator;
use App\Http;
use App\Http\Controllers\Controller;



class CarTypesController extends Controller
{   
    public function list()
    {
      $cars = car_type::all();
      return view('admin/car_type_list',compact('cars'));
    } 

    public function cars_types_new()
    {
    	$city = car_type::all();
      return view('admin/car_type_new');
    }   

    public function cars_types_view($id)
    {
      $service_data = car_type::where('id',$id)->get();
      return view('admin/car_type_view',compact('service_data'));
    }  
    public function cars_types_edit(Request $request)
    {

       $check = car_type::where('name',$request->name)->get();

      if (count($check) >0) {
          return redirect('admin/car-types-list')->with('errormsg','Car type names already exists');
        
      }
     $carName = $request->name;
     $update = car_type::where('id',$request->id);
                            $update->update(array(
                              'name'=>$carName,
                          ));
      if($update){
       return redirect('admin/car-types-list')->with('successmsg','car type names saved successfully');
      }
      else{
        return redirect('admin/car-types-list')->with('errormsg','Something went wrong');
      }
    }   

    public function cars_types_save(Request $request)
    {

      $check = car_type::where('name',$request->name)->get();

      if (count($check) >0) {
          return redirect('admin/car-types-list')->with('errormsg','Car type names already exists');
        
      }


      $car_name = new car_type();
      $car_name->name = $request->name;
      $car_name->save();
     
       if($car_name){
       return redirect('admin/car-types-list')->with('successmsg','New cars saved successfully');
      }
      else{
        return redirect('admin/car-types-list')->with('errormsg','Something went wrong');
      }
      
    } 
}
