<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Hash;
use Validator;
use App\Http\Controllers\Controller;

class AdminLoginController extends Controller
{   
    public function adminLogin()
    {
    	if(!empty(Auth::user()) && Auth::user()->role == 1){
      

    		return redirect('admin/dashboard');
      	}else{
      		return view('admin/admin_login');
      	}
    }
    public function dashboard(){
      //echo "123";exit();
      return view('admin/admin_dashboard');
    }

    public function postAdminLogin(Request $request){
      $rules=array('email'=>'required','password'=>'required');	
      $this->validate($request,$rules);
      $email=$request->email;
      $password=$request->password;
      $users=User::where('email',$email)->first(); 
      if(!empty($users)){ 
        if (Hash::check($password, $users->password)) {
             if(Auth::attempt(['email'=>$email,'password'=>$password,'role'=>1])){
                  return redirect('admin/dashboard');
             }
             else
                return redirect('/admin')->with('message','Incorrect Email id or Password');
        }
        else 
           return redirect('/admin')->with('message','Incorrect Email id or Password');
      }
      else
        return redirect('/admin')->with('message','Incorrect Email id or Password');
      
    }
    public function changepassword(){
       return view('admin.change_password');
   }

   public function updatepassword(Request $request){
       //dd($request->all());
       $rules=array('password'=>'required|min:6','rpassword'=>'required|min:6|same:password'); 
       $this->validate($request,$rules);
       $admin = User::where('role',1)->first();
       $admin->password = Hash::make($request->password);
       $admin->save();
       return redirect('/admin');
   }

    public function adminLogout()
    {
    	Auth::logout();
    	return redirect('/admin');
    }
}
