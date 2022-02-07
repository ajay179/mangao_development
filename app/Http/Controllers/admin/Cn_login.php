<?php

namespace App\Http\Controllers\admin;

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

    public function admin_login(Request $request){

         $request->validate([
            'email' => 'required',
            'password' => 'required',
        ],
        
        );

        $admin_data = array(
            'email' =>$request->email,
            'password' => $request->password
        );  
        if(Auth::guard('admin')->attempt($admin_data)){
          
            if ($request->remember === null) {
                setcookie('login_email', $request->email, 100);
                setcookie('login_password', $request->password, 100);
            } else {
                setcookie('login_email', $request->email, time() + 60 * 60 * 24 * 10);
                setcookie('login_password', $request->password, time() + 60 * 60 * 24 * 10);
            }
            $request->session()->put([
                '**^&%*$$username**$%#' => Auth::guard('admin')->user()->name,
                '*$%&%*id**$%#' => Auth::guard('admin')->user()->id,
                '**$%#email**^&%*' => Auth::guard('admin')->user()->email
            ]);

            if ($request->session()->has('**^&%*$$username**$%#', '*$%&%*id**$%#', '**$%#email**^&%*')) {
                return redirect('admin-dashbord')->with('message', 'Successfully Logged In!');
            } else {
                return redirect('admin')->with('error', 'You have entered wrong credentials.. Please try again...');
            }
        
        }else{
            return redirect()->back()->with('error', 'You have entered wrong password.. Please try again...');
        }
    }

}
