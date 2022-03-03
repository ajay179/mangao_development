<?php

namespace App\Http\Controllers\city_admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Cn_city_admin_orders extends Controller
{
    /**
     * Display a listing of the city admin account settlement.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $class_name ='Cn_city_admin_orders';
        return view('city_admin/orders/ongoing_orders',compact('class_name'));
    }


    /**
     * Display a listing of the  vendor account settlement .
     *
     * @return \Illuminate\Http\Response
     */

    public function fun_completed_orders()
    {
        $class_name ='Cn_city_admin_orders';
        return view('city_admin/orders/completed_orders',compact('class_name'));
    }


    /**
     * Display a listing of the  delivery boy account settlement
     *
     * @return \Illuminate\Http\Response
     */
    public function fun_cancelled_orders()
    {
        $class_name ='Cn_city_admin_orders';
        return view('city_admin/orders/cancelled_orders',compact('class_name'));
    }

    public function fun_returned_orders()
    {
        $class_name ='Cn_city_admin_orders';
        return view('city_admin/orders/returned_orders',compact('class_name'));
    }

}
