<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\md_account_settlement;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use DB;
use Config;

class Cn_account_settlement extends Controller
{
     /**
	 * Display a listing of the city admin account settlement.
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function index()
    {
        $class_name ='Cn_account_settlement';
        return view('admin/account-settlement/city_admin_account_settlement',compact('class_name'));
    }


    /**
	 * Display a listing of the  vendor account settlement .
	 *
	 * @return \Illuminate\Http\Response
	 */

    public function vendor_account_settlement_page()
    {
        $class_name ='Cn_account_settlement';
        return view('admin/account-settlement/vendor_account_settlement',compact('class_name'));
    }


    /**
	 * Display a listing of the  delivery boy account settlement
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function delivery_boy_account_settlement_page()
    {
        $class_name ='Cn_account_settlement';
        return view('admin/account-settlement/delivery_boy_account_settlement',compact('class_name'));
    }


}
