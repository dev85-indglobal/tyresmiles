<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Model\car_name;
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
}
