<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\MangaoStaticUseradmin;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Storage;

class Cn_global_setting extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fun_view_global_setting()
    {
        $admin_data = DB::table('mangao_static_useradmin')->where('id','=',session()->get('*$%&%*id**$%#'))->select('name','email','mobile_number','id','admin_image')->where('user_type','=','super_admin')->first();

        $url =Storage::url($admin_data->admin_image);
            $admin_data->show_admin_img = url($url);
        $class_name ='cn_global_setting';
        return view('admin/global_setting/vw_add_global_setting',compact('class_name','admin_data'));
    }

    /**
     * This function are used to update admin data.
     *
     * @return \Illuminate\Http\Response
     */
    public function fun_admin_data_action(Request $request)
    {
       $this->validate($request, [
            'email' => 'required|email'
        ]);
        
        // function used for add single array 
        $MangaoStaticUseradmin = new MangaoStaticUseradmin;

        $admin_id = session()->get('*$%&%*id**$%#');
        $check_duplicate_email = MangaoStaticUseradmin::where('email', $request->email)->where('id','<>', $admin_id)->where('status','<>', 3)->get();
        if($check_duplicate_email->isNotEmpty()){
            return redirect()->route('view.global.setting')->with('error', 'This email already added.');
        }else{

            $filename = '';
            if($request->has('admin_image')){
                $filename = time().'_'.$request->file('admin_image')->getClientOriginalName();
                $filePath = $request->file('admin_image')->storeAs('public/admin_image',$filename);  
            }else{
              
                $filePath = $request->admin_image_old;
            }

            if(!empty($admin_id)){
                $msg = "updated";
                $MangaoStaticUseradmin = MangaoStaticUseradmin::find($admin_id);
                $MangaoStaticUseradmin->updated_at   = date('Y-m-d h:i:s');
                $MangaoStaticUseradmin->updated_by   = $admin_id;
                $MangaoStaticUseradmin->updated_ip_address   = $request->ip();
                $MangaoStaticUseradmin->email = $request->email;
                $MangaoStaticUseradmin->name = $request->name;
                $MangaoStaticUseradmin->mobile_number = $request->mobile_number;
                $MangaoStaticUseradmin->admin_image = $filePath;
                $MangaoStaticUseradmin->save();
                return redirect()->route('view.global.setting')->with('message', 'Admin data '. $msg);
            }else{
                return redirect()->route('view.global.setting')->with('message', 'Something went wrong');
            }
        }
    }
}
