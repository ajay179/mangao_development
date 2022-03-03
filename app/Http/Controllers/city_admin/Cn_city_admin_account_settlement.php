<?php

namespace App\Http\Controllers\city_admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Cn_city_admin_account_settlement extends Controller
{
    /**
	 * Display a listing of the city admin account settlement.
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function index()
    {
        $class_name ='Cn_city_admin_account_settlement';
        return view('city_admin/account-settlement/city_admin_account_settlement',compact('class_name'));
    }


    /**
	 * Display a listing of the  vendor account settlement .
	 *
	 * @return \Illuminate\Http\Response
	 */

    public function vendor_account_settlement_page()
    {
        $class_name ='Cn_city_admin_account_settlement';
        return view('city_admin/account-settlement/vendor_account_settlement',compact('class_name'));
    }


    /**
	 * Display a listing of the  delivery boy account settlement
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function delivery_boy_account_settlement_page()
    {
        $class_name ='Cn_city_admin_account_settlement';
        return view('city_admin/account-settlement/delivery_boy_account_settlement',compact('class_name'));
    }

}
