<?php

namespace App\Http\Controllers\city_admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Auth;
use DB;
use Config;


class Cn_cityadmin_management extends Controller
{
    /**
     * This are used to load the view of delivery management .
     *
     * @return \Illuminate\Http\Response
     */
    public function fun_delivery_management()
    {
        // $redeem_point_details = DB::table(Config::get('constants.MANGAO_REDEEM_POINTS').'  as MRP')->where('MRP.status', '<>', 3)->where('MRP.points_type', '=', 'Reedem Points')->select('MRP.reward_points','MRP.value', 'MRP.id')->get();
        // if(!empty($redeem_point_details[0]->id)){
        //     $redeem_point_details[0]->id = Crypt::encryptString($redeem_point_details[0]->id);
        // }
            

        return view('city_admin.management.vw_delivery_management');
    }


    public function fun_management_management()
    {
        try {
            $id = session()->get('&%*id$%#');
            $cityadmin_data = DB::table(Config::get('constants.MANGAO_CITY_ADMIN').'  as MCA')
                ->join(Config::get('constants.MANGAO_CITY_MASTER').'  as MCM','MCM.id','=','MCA.city_id')
                ->where('MCA.status', '<>', 3)
                ->where('MCA.id', '=', $id)
                ->select('MCA.city_id', 'MCA.id','MCA.admin_name','MCA.address','MCA.commision','MCA.admin_email','MCA.admin_mobile','MCA.admin_img','MCA.encrypt_password','MCM.city_name')
                ->get();
            
            
            // Make id encrypt
            $cityadmin_data[0]->id = Crypt::encryptString($cityadmin_data[0]->id);
            
            //make image url
            $url =Storage::url($cityadmin_data[0]->admin_img);
            $cityadmin_data[0]->show_admin_img = url($url);
            
            //decrypt password
            $cityadmin_data[0]->encrypt_password = Crypt::decryptString($cityadmin_data[0]->encrypt_password);
            
            $class_name ='cn_master_cityadmin';
           
            if(!empty($cityadmin_data[0])){
                return view('city_admin.management.vw_profile_management',compact('class_name','cityadmin_data'));
            }else{
               return redirect('city-admin')->with('error', 'something went wrong');
            }
        } catch (DecryptException $e) {
            return redirect('city-admin')->with('error', 'something went wrong');
        }
    }
    
}
