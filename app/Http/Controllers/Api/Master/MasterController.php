<?php

namespace App\Http\Controllers\Api\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\City;
use App\Model\Country;
use App\Model\Master_service_categories;
use App\Model\car_type;
use App\Model\car_name;
use App\Model\basic_car_wash;
use App\Model\full_car_wash;
use App\Model\Two_d_wheel_allignment;
use App\Model\Three_d_wheel_allignment_package;
use App\Model\Three_d_wheel_allignment;
use App\Model\media;



use Validator;

class MasterController extends Controller
{

	//get_master_services
    public function get_Master_service_categories()
    {
    	try{
			$return_arr = array();
            $master_services = Master_service_categories::select('master_service_categories.id','master_service_categories.name','media.media_image','media.media_image_thumb')
                               ->join('media','media.category_id','=','master_service_categories.id')
                               ->get();

			foreach ($master_services as $ms) {
					
					$return_arr[] = array(
						'master_service_id' =>$ms->id,
                        'service_name' =>$ms->name,	
                        'media' => url($ms->media_image),
                        'media_thumb' =>url($ms->media_image_thumb),					
					);

				
			}
			return response()->json(['success' => true, 'data' => $return_arr, 'message' => 'Master_service_categories'],200);
		}
		catch(Exception $e){
			return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"),500);
		}
    }
    //get_master_car_types
    public function get_master_car_types()
    {
    	try{
			$return_arr = array();
           $car_types = car_type::all();

			foreach ($car_types as $ct) {
					$return_arr[] = array(
						'Car_type_id' =>$ct->id,
                        'Car_type' =>$ct->name,						
					);
			}
			return response()->json(['success' => true, 'data' => $return_arr, 'message' => 'master_car_types'],200);
		}
		catch(Exception $e){
			return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"),500);
		}
    }
    //get_master_cars
    public function get_master_cars()
    {
    	try{
			$return_arr = array();
           $car_types = car_name::all();

			foreach ($car_types as $ct) {
					$return_arr[] = array(
						'Car_id' =>$ct->id,
						'type_id'=>$ct->type_id,
                        'Car_name' =>$ct->name,						
					);
			}
			return response()->json(['success' => true, 'data' => $return_arr, 'message' => 'get_master_cars'],200);
		}
		catch(Exception $e){
			return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"),500);
		}
    }

    //get_master_basic_car_wash
    public function get_master_basic_car_wash()
    {   
    	try{
			$return_arr = array();
           $basic = basic_car_wash::all();

			foreach ($basic as $b) {
					$return_arr[] = array(
						'id' =>$b->id,
                        'category_id' =>$b->category_id,
                        'car_wash_details' =>$b->name,
                        'currency' =>$b->currency,
                        'price' =>$b->price,						
					);
			}
			return response()->json(['success' => true, 'data' => $return_arr, 'message' => 'get_master_basic_car_wash'],200);
		}
		catch(Exception $e){
			return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"),500);
		}
    }

    //get_master_Full_car_wash
    public function get_master_full_car_wash()
    {
    	try{
			$return_arr = array();
           $two_d = full_car_wash::all();

			foreach ($two_d as $d) {
					$return_arr[] = array(
						'id' =>$d->id,
                        'category_id' =>$d->category_id,
                        'car_wash_details' =>$d->name,
                        'currency' =>$d->currency,
                        'price' =>$d->price,
					);
			}
			return response()->json(['success' => true, 'data' => $return_arr, 'message' => 'get_master_full_car_wash'],200);
		}
		catch(Exception $e){
			return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"),500);
		}
    }

    //get_two_d_wheel_allignment
    public function get_two_d_wheel_allignment()
    {
    	try{
			$return_arr = array();
           $basic = Two_d_wheel_allignment::all();

			foreach ($basic as $b) {
					$return_arr[] = array(
						'id' =>$b->id,
                        'category_id' =>$b->category_id,
                        'wheel_allignment_details' =>$b->name,
                        'currency' =>$b->currency,
                        'price' =>$b->price,							
					);
			}
			return response()->json(['success' => true, 'data' => $return_arr, 'message' => 'get_two_d_wheel_allignment'],200);
		}
		catch(Exception $e){
			return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"),500);
		}
    }

    //get_three_d_wheel_allignment_packages
    public function get_three_d_wheel_allignment_package()
    {
    	try{
			$return_arr = array();
           $three_d = Three_d_wheel_allignment_package::all();

			foreach ($three_d as $d) {
					$return_arr[] = array(
						'id' =>$d->id,
                        'category_id' =>$d->category_id,
                        'package_name' =>$d->name,
                        'currency' =>$d->currency,
                        'price' =>$d->price,							
					);
			}
			return response()->json(['success' => true, 'data' => $return_arr, 'message' => 'get_three_d_wheel_allignment_package'],200);
		}
		catch(Exception $e){
			return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"),500);
		}
    }

     //get_three_d_wheel_allignment_packages
    public function get_three_d_wheel_allignment()
    {
    	try{
			$return_arr = array();
           $basic = Three_d_wheel_allignment::all();
           	        
			foreach ($basic as $b) {

			$package = Three_d_wheel_allignment_package::where('id',$b->package_id)->get();
			foreach ($package as $p) {
				
			
					$return_arr[] = array(
						'id' =>$b->id,
						'category_id'=>$b->category_id,
						'package_id' =>$b->package_id,
                        'package_name' =>$p->package_name,
                        'currency' =>$p->currency,
                        'price' =>$p->price,
                        'wheel_allignment_details' =>$b->type_name,							
					);
				}	
			}
			return response()->json(['success' => true, 'data' => $return_arr, 'message' => 'get_three_d_wheel_allignment'],200);
		}
		catch(Exception $e){
			return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"),500);
		}
    }

     //for GET master city
    public function get_master_city()
    {
    	try{
            $return_arr = array();
            $cities = City::all();

            foreach ($cities as $city) {
                    $return_arr[] = array(
                        'city_id' => $city->city_id,
                        'city_name' => $city->city_name,
                        'city_state' => $city->city_state,
                    );
            }
            return response()->json(['success' => true, 'data' => $return_arr, 'message' => 'cities'],200);
        }
        catch(Exception $e){
            return response()->json(array('success' => false, 'error' => 'server_error', 'message' => "Something went wrong.<br />Please try again"),500);
        }
    }
}
