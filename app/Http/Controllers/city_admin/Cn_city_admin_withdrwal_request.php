<?php

namespace App\Http\Controllers\city_admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Cn_city_admin_withdrwal_request extends Controller
{
     /**
	 * Display a listing of the city admin withdrwal request.
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function index()
    {
        $class_name ='Cn_city_admin_withdrwal_request';
        return view('city_admin/withdrwal-request/city_admin_withdrwal_page',compact('class_name'));
    }


    /**
	 * Display a listing of the  vendor withdrwal request.
	 *
	 * @return \Illuminate\Http\Response
	 */

    public function fun_vendor_withdrwal_page()
    {
        $class_name ='Cn_city_admin_withdrwal_request';
        return view('city_admin/withdrwal-request/vendor_withdrwal_page',compact('class_name'));
    }


    /**
	 * Display a listing of the  delivery boy withdrwal request.
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function fun_delivery_boy_withdrwal_page()
    {
        $class_name ='Cn_city_admin_withdrwal_request';
        return view('city_admin/withdrwal-request/delivery_boy_withdrwal_page',compact('class_name'));
    }

}
