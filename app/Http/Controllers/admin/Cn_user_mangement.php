<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Md_city_admin_vendor;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use DB;
use Config;

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

    public function get_vendor_listing_for_superadmin(Request $request)
    { 
        if ($request->ajax()) {
            $data = DB::table(Config::get('constants.MANGAO_CITY_ADMIN_VENDOR').'  as MCAV')
                ->join(Config::get('constants.MANGAO_CITY_MASTER').' as MCM', 'MCM.id', 'MCAV.vendor_cITY_id')
                ->where('MCAV.status', '<>', 3)
                ->where('MCM.status', '<>', 3)
                // ->where('MCAV.created_by', '=', session()->get('&%*id$%#'))
                ->select('MCAV.store_name','MCAV.store_owner_name','MCAV.vendor_address','MCAV.vendor_email','MCAV.vendor_mobile_no','MCAV.id','MCAV.created_at','MCM.city_name')
                ->get();


            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $btn = '<a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record-of-city-admin" flash="Vendor" table="' . Crypt::encryptString('mangao_vendors') . '" redirect-url="' . Crypt::encryptString('cityadmin/view-vendor') . '" title="Delete" ><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data->created_at));
                    return $date_with_format;
                })
                ->addColumn('wallet_amount', '0')
                ->addColumn('total_amount_settled', '0')
                ->addColumn('total_order_completed', '0')
                ->addColumn('rating', '0')
                ->addColumn('status', 'pending')
                ->rawColumns(['date'])
                ->rawColumns(['action'])
                ->make(true);
        }
    }

}
