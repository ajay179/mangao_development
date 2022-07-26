<?php

namespace App\Http\Controllers\vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Cn_vendor_my_banner extends Controller
{
    /**
     * Display a listing of the my banner.
     *
     * @return \Illuminate\Http\Response
     */
    public function fun_vendor_my_banner()
    {
        $class_name ="cn_vendor_my_banner";
        return view('vendor.master.vw_my_banner_list',compact('class_name'));
    }


}
