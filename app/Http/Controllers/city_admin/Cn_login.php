<?php

namespace App\Http\Controllers\city_admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;

class Cn_login extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // echo $password = Hash::make('123456');
        
        // die();
        return view('adminarea.login.login');
    }

    public function city_admin_login(Request $request){

         $request->validate([
            'email' => 'required',
            'password' => 'required',
        ],
        
        );

        $admin_data = array(
            'admin_email' =>$request->email,
            'password' => $request->password
        );  
        if(Auth::guard('city_admin')->attempt($admin_data)){
          
            if ($request->remember === null) {
                setcookie('city_admin_login_email', $request->email, 100);
                setcookie('city_admin_login_password', $request->password, 100);
            } else {
                setcookie('city_admin_login_email', $request->email, time() + 60 * 60 * 24 * 10);
                setcookie('city_admin_login_password', $request->password, time() + 60 * 60 * 24 * 10);
            }
            $request->session()->put([
                '&%*$$cityadminusername$%#' => Auth::guard('city_admin')->user()->admin_name,
                '&%*id$%#' => Auth::guard('city_admin')->user()->id,
                '$%#city_admin_email&%*' => Auth::guard('city_admin')->user()->admin_email,
                '$%#city_id&%*' => Auth::guard('city_admin')->user()->city_id
            ]);

            if ($request->session()->has('&%*$$cityadminusername$%#', '&%*id$%#', '$%#city_admin_email&%*')) {
                return redirect('city-admin-dashbord')->with('message', 'Successfully Logged In!');
            } else {
                return redirect('city-admin-login')->with('error', 'You have entered wrong credentials.. Please try again...');
            }
        
        }else{
            return redirect()->back()->with('error', 'You have entered wrong password.. Please try again...');
        }
    }

}
