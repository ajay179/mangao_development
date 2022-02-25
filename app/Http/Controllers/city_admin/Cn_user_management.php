<?php

namespace App\Http\Controllers\city_admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Cn_user_management extends Controller
{
    public function fun_vendor_list()
    {
        return view('city_admin.user_management.vw_vendor_list');
    }

    public function fun_add_vendor()
    {
        return view('city_admin.user_management.vw_add_vendor');
    }


    public function fun_delivery_boy_list()
    {
        return view('city_admin.user_management.vw_delivery_boy_list');
    }

    public function fun_add_delivery_boy()
    {
        return view('city_admin.user_management.vw_add_delivery_boy');
    }


    
    
}
