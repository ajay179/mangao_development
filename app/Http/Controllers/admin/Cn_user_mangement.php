<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Md_city_admin_vendor;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use DB;
use Config;
use Auth;

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

        Session::put([
            '&%*$^vendorusername$%#' => null,
            '&&*id$##' => null,
            '$%vendor_email&%*' => null,
            '$%vendor_category_type_id&%*' => null,
            '$%vendor_category_type&%*' => null,
            'super@dmin|ogin' => null,
            'super@dmin|oginTYpe' => null
        ]);
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
                ->select('MCAV.store_name','MCAV.store_owner_name','MCAV.vendor_address','MCAV.vendor_email','MCAV.vendor_mobile_no','MCAV.id','MCAV.created_at','MCM.city_name','MCAV.status')
                ->get();


            return Datatables::of($data)
             
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $btn = '<a href="javascript:void(0);" status="'.Crypt::encryptString(3).'" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs superadmin-change-vendor-status" flash="Vendor" table="' . Crypt::encryptString('mangao_vendors') . '"  title="Delete" ><i class="fa fa-trash"></i></a> <a href="'. url("/vendor-secret-login") ."/". Crypt::encryptString($data->id).'" class="edit btn btn-primary btn-xs"><i class="fa fa-sign-in"></i> login</a> ';
                    return $btn;
                })
                ->addColumn('status', function($data){
                    $status_class = (!empty($data->status)) && ($data->status == 1) ? 'tgle-on' : 'tgle-off'; 
                    $status = '<a href="javascript:void(0);" flash="Vendor" status="'.Crypt::encryptString($data->status).'" table="' . Crypt::encryptString('mangao_vendors') . '" data-id="' . Crypt::encryptString($data->id) . '"  class="superadmin-change-vendor-status"  > <i class="fa fa-toggle-on '. $status_class.' " aria-hidden="true" title="Active"></i></a>';
                    return $status;
                })
                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data->created_at));
                    return $date_with_format;
                })
                ->addColumn('wallet_amount', '0')
                ->addColumn('total_amount_settled', '0')
                ->addColumn('total_order_completed', '0')
                ->addColumn('rating', '0')
                // ->addColumn('status', 'pending')
                ->rawColumns(['date','status','action'])
                ->make(true);
        }
    }

    

    public function fun_vendor_secret_login($encrypt_id)
    {
        try {
            
            $id =  Crypt::decryptString($encrypt_id);
            $vendor_data = DB::table(Config::get('constants.MANGAO_VENDORS').'  as MV')->where('MV.status', '<>', 3)->where('MV.id', '=', $id)->select('MV.store_name', 'MV.id','MV.category_id','MV.vendor_email','MV.encrypt_password','MV.category_type')->get();
            
            if(!empty($vendor_data[0])){
                $admin_data = array(
                    'vendor_email' =>$vendor_data[0]->vendor_email,
                    'password' => Crypt::decryptString($vendor_data[0]->encrypt_password)
                );
                if(Auth::guard('vendor')->attempt($admin_data)){
                    // Session::flush();
                    Session::put([
                        '&%*$^vendorusername$%#' => Auth::guard('vendor')->user()->store_name,
                        '&&*id$##' => Auth::guard('vendor')->user()->id,
                        '$%vendor_email&%*' => Auth::guard('vendor')->user()->vendor_email,
                        '$%vendor_category_type_id&%*' => Auth::guard('vendor')->user()->category_id,
                        '$%vendor_category_type&%*' => Auth::guard('vendor')->user()->category_type,
                        'super@dmin|ogin' => '^&*%123$%',
                        'super@dmin|oginTYpe' => 'vendor'
                    ]);
                    
                    if (Session::has('&%*$^vendorusername$%#', '&&*id$##', '$%vendor_email&%*')) {
                        return redirect('vendor-dashbord')->with('message', 'Successfully Logged In!');
                    } else {
                        return redirect('view-all-vendor')->with('error', 'You have entered wrong credentials.. Please try again...');
                    }
                
                }else{
                    return redirect('view-all-vendor')->with('error', 'You have entered wrong password.. Please try again...');
                }
            }else{
               return redirect('view-all-vendor')->with('error', 'something went wrong');
            }
        } catch (DecryptException $e) {
            return redirect('view-all-vendor')->with('error', 'something went wrong');
        }

    }

}
