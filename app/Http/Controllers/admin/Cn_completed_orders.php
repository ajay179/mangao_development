<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Cn_completed_orders extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $class_name ='Cn_completed_orders';
        return view('admin/orders/completed_orders',compact('class_name'));
    }

}
