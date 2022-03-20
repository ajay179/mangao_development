<?php

namespace App\Http\Controllers\city_admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Auth;

class Cn_city_admin_dashboard extends Controller
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
        // return $city_admin =  Auth::guard('city_admin')->user();

//         $response = Gate::inspect('isCityAdmin');
// return $response;
        return view('city_admin.dashbord.dashbord');
    }
}
