<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Cn_user_mangement extends Controller
{
    /**
     * Display a listing of all user list.
     *
     * @return \Illuminate\Http\Response
     */
    public function fun_all_user()
    {
        $class_name ='cn_user_mangement';
        return view('admin/user-management/vw_all_user_list',compact('class_name'));
    }

     /**
     * Display a listing of all vendor list.
     *
     * @return \Illuminate\Http\Response
     */
    public function fun_all_vendor()
    {
        $class_name ='cn_user_mangement';
        return view('admin/user-management/vw_all_vendor_list',compact('class_name'));
    }

    /**
     * Display a listing of all vendor delivery boy.
     *
     * @return \Illuminate\Http\Response
     */
    public function fun_all_delivery_boy()
    {
        $class_name ='cn_user_mangement';
        return view('admin/user-management/vw_all_delivery_boy_list',compact('class_name'));
    }



}
