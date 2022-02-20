<?php

namespace App\Http\Controllers\city_admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        return view('city_admin.dashbord.dashbord');
    }
}
