<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\Md_city_master;

class Cn_master_cityadmin extends Controller
{
    /**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function index()
    {
        $class_name ='Cn_master_cityadmin';
        return view('admin/city-cityadmin/city_admin_master',compact('class_name'));
    }

    /**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function add_cityadmin()
    {
        $class_name ='Cn_master_cityadmin';
        $city_data = Md_city_master::latest()->where('status','<>',3)->select('city_name','id','created_at')->get();
        return view('admin/city-cityadmin/add_city_admin_master',compact('class_name','city_data'));
    }

    
}
