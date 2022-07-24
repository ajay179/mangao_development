<?php

namespace App\Http\Controllers\city_admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use App\Models\Md_city_admin;
use App\Models\Md_delivery_management_charge;
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
        $delivery_mangement_details = Md_delivery_management_charge::where('status', '<>', 3)->select('upto_3_km_charge','charge_after_3_km','deli_boy_charge_upto_3km','deli_boy_charge_after_3km', 'id')->get();
        if(!empty($delivery_mangement_details[0]->id)){
            $delivery_mangement_details[0]->id = Crypt::encryptString($delivery_mangement_details[0]->id);
        }
            
        return view('city_admin.management.vw_delivery_management',compact('delivery_mangement_details'));
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
    
     /**
     * This are used to add city .
     *
     * @return \Illuminate\Http\Response
     */
    public function fun_cityadmin_update_profile(Request $request)
    {
       $this->validate($request, [
            'city_id' => 'required','admin_name' => 'required','address' => 'required','commision' => 'required','admin_mobile' => 'required','password' => 'required'
        ]);
        
        // function used for add single array 
        $Md_city_admin = new Md_city_admin;

        $check_duplicate_city_admin = Md_city_admin::where('admin_email', $request->admin_email);
        if(!empty($request->txtpkey)){
          $check_duplicate_city_admin =  $check_duplicate_city_admin->where('id','<>', Crypt::decryptString($request->txtpkey));
        }
        $check_duplicate_city_admin = $check_duplicate_city_admin->where('status','<>', 3)->get();
        if($check_duplicate_city_admin->isNotEmpty()){
            return redirect()->route('city.admin')->with('error', 'This city admin email already added.');
        }else{

            if(!empty($request->txtpkey)){
                $msg = "updated";
                $txtpkey =  Crypt::decryptString($request->txtpkey);
                $data = Md_city_admin::where('id', $txtpkey)->get();
                if($data->isEmpty()){
                    return redirect()->route('city.admin')->with('message', 'something went wrong');
                }else{
                    $Md_city_admin = Md_city_admin::find($txtpkey);
                    $Md_city_admin->updated_at   = date('Y-m-d h:i:s');
                    $Md_city_admin->updated_by   = session()->get('*$%&%*id**$%#');
                    $Md_city_admin->updated_ip_address   = $request->ip();
                }
            }
            $filename = '';
            if($request->has('admin_image')){
                $filename = time().'_'.$request->file('admin_image')->getClientOriginalName();
                $filePath = $request->file('admin_image')->storeAs('public/admin_image',$filename);  
            }else{
                $filePath = $request->admin_image_old;
            }
            $Md_city_admin->city_id   = $request->city_id;
            $Md_city_admin->admin_name   = $request->admin_name;
            $Md_city_admin->address   = $request->address;
            $Md_city_admin->commision   = $request->commision;
            $Md_city_admin->admin_mobile   = $request->admin_mobile;
            $Md_city_admin->admin_img   =  $filePath;
            $Md_city_admin->password   = Hash::make($request->password);
            $Md_city_admin->encrypt_password   = Crypt::encryptString($request->password);
            $Md_city_admin->save();

            // this statement are used for getting the last inserted id
           //  $Md_city_master->id;   

            return redirect()->route('cityadmin.view.profile.management')->with('message', 'Profile '. $msg);
        }
    }

    public function fun_delivery_management_action(Request $request)
    {
         $this->validate($request, [
           'upto_3_km_charge' => 'required','charge_after_3_km' => 'required','deli_boy_charge_upto_3km' => 'required','deli_boy_charge_after_3km' => 'required'
        ]);

        
        // function used for add single array 
        $Md_delivery_management_charge = new Md_delivery_management_charge;
        
            if(!empty($request->txtpkey)){
            $msg = "updated";
            $txtpkey =  Crypt::decryptString($request->txtpkey);
            $data = Md_delivery_management_charge::where('id', $txtpkey)->get();
            if($data->isEmpty()){
                return redirect()->back()->with('message', 'something went wrong');
            }else{

                $Md_delivery_management_charge = Md_delivery_management_charge::find($txtpkey);
                $Md_delivery_management_charge->updated_at   = date('Y-m-d h:i:s');
                $Md_delivery_management_charge->updated_by   = session()->get('*$%&%*id**$%#');
                $Md_delivery_management_charge->updated_ip_address   = $request->ip();
            }
        }else{
            $msg = "Added";
            $Md_delivery_management_charge->created_at   = date('Y-m-d h:i:s');
            $Md_delivery_management_charge->created_by   = session()->get('*$%&%*id**$%#');
            $Md_delivery_management_charge->created_ip_address   = $request->ip();
        }      
       
        $Md_delivery_management_charge->upto_3_km_charge   = $request->upto_3_km_charge;
        $Md_delivery_management_charge->charge_after_3_km   = $request->charge_after_3_km;
        $Md_delivery_management_charge->deli_boy_charge_upto_3km   = $request->deli_boy_charge_upto_3km;
        $Md_delivery_management_charge->deli_boy_charge_after_3km   = $request->deli_boy_charge_after_3km;
        $Md_delivery_management_charge->save();

        // this statement are used for getting the last inserted id
       //  $Md_mangao_banner->id;   

        return redirect()->back()->with('message', ' App Refer Points '. $msg);

    }

}
