<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Model\Service_Sub_Categorie;
use App\Model\Master_service_categories;
use App\Model\car_type;
use App\Model\basic_car_wash;
use Auth;
use Hash;
use Validator;
use App\Http\Controllers\Controller;

class ServiceSubCategoriesController extends Controller
{
     public function list()
    {
      $Sub_categories = Service_Sub_Categorie::all();
      return view('admin/service_sub_categories_list',compact('Sub_categories'));
    } 

    public function service_sub_categories_new()
    {
    	$categories = Master_service_categories::all();
      $Sub_categories = Service_Sub_Categorie::all();
      return view('admin/service_sub_categories_new',compact('Sub_categories','categories'));
    }   

    public function service_sub_categories_view($id)
    {
      $service_data = Service_Sub_Categorie::where('sub_category_id',$id)->get();
      $service_types =Master_service_categories::all();
      return view('admin/service_sub_categories_view',compact('service_data','service_types'));
    }  
    public function service_sub_categories_edit(Request $request)
    {

      $check = Service_Sub_Categorie::where('sub_category_name',$request->sub_category_name)->get();

      if (count($check) >0) {
          return redirect('admin/service-sub-categories-list')->with('errormsg','sub category name already exists');
        
      }
                 $service_sub =$request->sub_category_name;
                 $type_id =$request->category_id;
                 $services_exist =$request->services_exist;
                 $active=$request->active;
                 $update = Service_Sub_Categorie::where('sub_category_id',$request->id);
                                        $update->update(array(
                              'sub_category_name'=>$service_sub,
                              'category_id'=>$type_id,
                              'services_exist'=>$services_exist,
                              'active'=>$active,
                          ));
      if($update){
       return redirect('admin/service-sub-categories-list')->with('successmsg','service Sub category  detail updated successfully');
      }
      else{
        return redirect('admin/service-sub-categories-list')->with('errormsg','Something went wrong');
      }
    }   

    public function service_sub_categories_save(Request $request)
    {
 
       $check = Service_Sub_Categorie::where('sub_category_name',$request->sub_category_name)->get();

      if (count($check) >0) {
          return redirect('admin/service-sub-categories-list')->with('errormsg','service sub category  name already exists');
        
      }

      $sub_category = new Service_Sub_Categorie();
      $sub_category->category_id = $request->category_id;
      $sub_category->sub_category_name = $request->sub_category_name;
      $sub_category->services_exist = $request->services_exist;
      $sub_category->active = $request->active;
      $sub_category->save();

       if($sub_category){

       return redirect('admin/service-sub-categories-list')->with('successmsg','New cars saved successfully');
      }
      else{
        return redirect('admin/service-sub-categories-list')->with('errormsg','Something went wrong');
      }
      
    } 
}
