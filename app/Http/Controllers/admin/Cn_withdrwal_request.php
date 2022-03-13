<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\md_withdrwal_request;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use DB;
use Config;



class Cn_withdrwal_request extends Controller
{
    /**
	 * Display a listing of the city admin withdrwal request.
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function index()
    {
        $class_name ='Cn_withdrwal_request';
        return view('admin/withdrwal-request/city_admin_withdrwal',compact('class_name'));
    }


    /**
	 * Display a listing of the  vendor withdrwal request.
	 *
	 * @return \Illuminate\Http\Response
	 */

    public function vendor_withdrwal_page()
    {
        $class_name ='Cn_withdrwal_request';
        return view('admin/withdrwal-request/vendor_withdrwal',compact('class_name'));
    }


    /**
	 * Display a listing of the  delivery boy withdrwal request.
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function delivery_boy_withdrwal_page()
    {
        $class_name ='Cn_withdrwal_request';
        return view('admin/withdrwal-request/delivery_boy_withdrwal',compact('class_name'));
    }


}
