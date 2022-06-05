<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Cn_global_setting extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fun_view_global_setting()
    {
        $class_name ='cn_global_setting';
        return view('admin/global_setting/vw_add_global_setting',compact('class_name'));
    }

    /**
     * This are used to add city .
     *
     * @return \Illuminate\Http\Response
     */
    public function cityAction(Request $request)
    {
       $this->validate($request, [
            'city_name' => 'required'
        ]);
        
        // function used for add single array 
        $Md_city_master = new Md_city_master;

        $check_duplicate_city = Md_city_master::where('city_name', $request->city_name);
        if(!empty($request->txtpkey)){
          $check_duplicate_city =  $check_duplicate_city->where('id','<>', Crypt::decryptString($request->txtpkey));
        }
        $check_duplicate_city = $check_duplicate_city->where('status','<>', 3)->get();
        if($check_duplicate_city->isNotEmpty()){
            return redirect()->route('city')->with('error', 'This city already added.');
        }else{
            if(!empty($request->txtpkey)){
                $msg = "updated";
                $txtpkey =  Crypt::decryptString($request->txtpkey);
                $data = Md_city_master::where('id', $txtpkey)->get();
                if($data->isEmpty()){
                    return redirect()->route('city')->with('message', 'something went wrong');
                }else{
                    $Md_city_master = Md_city_master::find($txtpkey);
                    $Md_city_master->updated_at   = date('Y-m-d h:i:s');
                    $Md_city_master->updated_by   = session()->get('*$%&%*id**$%#');
                    $Md_city_master->updated_ip_address   = $request->ip();
                }
            }else{
                $msg = "Added";
                $Md_city_master->created_at   = date('Y-m-d h:i:s');
                $Md_city_master->created_by   = session()->get('*$%&%*id**$%#');
                $Md_city_master->created_ip_address   = $request->ip();
            }           
            $Md_city_master->city_name   = $request->city_name;
            $Md_city_master->save();

            // this statement are used for getting the last inserted id
           //  $Md_city_master->id;   

            return redirect()->route('city')->with('message', 'City '. $msg);
        }
    }
}
