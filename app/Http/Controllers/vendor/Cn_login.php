<?php

namespace App\Http\Controllers\vendor;

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

    public function vendor_login(Request $request){

         $request->validate([
            'email' => 'required',
            'password' => 'required',
        ],
        );

         // return $request;
        $admin_data = array(
            'vendor_email' =>$request->email,
            'password' => $request->password
        );  
        if(Auth::guard('vendor')->attempt($admin_data)){
          
            if ($request->remember === null) {
                setcookie('vendor_login_email', $request->email, 100);
                setcookie('vendor_login_password', $request->password, 100);
            } else {
                setcookie('vendor_login_email', $request->email, time() + 60 * 60 * 24 * 10);
                setcookie('vendor_login_password', $request->password, time() + 60 * 60 * 24 * 10);
            }
            $request->session()->put([
                '&%*$^vendorusername$%#' => Auth::guard('vendor')->user()->store_name,
                '&&*id$##' => Auth::guard('vendor')->user()->id,
                '$%vendor_email&%*' => Auth::guard('vendor')->user()->vendor_email,
                '$%vendor_category_type_id&%*' => Auth::guard('vendor')->user()->category_id
            ]);

            if ($request->session()->has('&%*$^vendorusername$%#', '&&*id$##', '$%vendor_email&%*')) {
                return redirect('vendor-dashbord')->with('message', 'Successfully Logged In!');
            } else {
                return redirect('vendor-login')->with('error', 'You have entered wrong credentials.. Please try again...');
            }
        
        }else{
            return redirect()->back()->with('error', 'You have entered wrong password.. Please try again...');
        }
    }

}
