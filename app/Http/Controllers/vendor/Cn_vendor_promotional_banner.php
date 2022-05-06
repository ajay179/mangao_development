<?php

namespace App\Http\Controllers\vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use DB;
use Config;
use Validator;

class Cn_vendor_promotional_banner extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fun_view_promotional_banner()
    {
        $class_name = 'cn_vendor_category';
        return view('vendor.promotional_banner.vw_promotional_banner',compact('class_name'));
    }
}
