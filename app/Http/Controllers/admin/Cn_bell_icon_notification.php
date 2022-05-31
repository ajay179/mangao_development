<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Md_city_master;
use App\Models\Md_bell_icon_notification_master;
use Illuminate\Support\Facades\Crypt;
use DataTables;

class Cn_bell_icon_notification extends Controller
{

    public function fun_user_bell_icon_notification()
    {
        $city_data = Md_city_master::latest()->where('status','<>',3)->select('city_name','id','created_at')->get();
        $class_name = "cn_bell_icon_notification";
        return view('admin/bell_icon_notification/vw_user_bell_icon_notification',compact('class_name','city_data'));
    }

    public function fun_vendor_bell_icon_notification()
    {
        $city_data = Md_city_master::latest()->where('status','<>',3)->select('city_name','id','created_at')->get();
        $class_name = "cn_bell_icon_notification";
        return view('admin/bell_icon_notification/vw_vendor_bell_icon_notification',compact('class_name','city_data'));
    }

    public function fun_delivery_boy_bell_icon_notification()
    {
        $city_data = Md_city_master::latest()->where('status','<>',3)->select('city_name','id','created_at')->get();
        $class_name = "cn_bell_icon_notification";
        return view('admin/bell_icon_notification/vw_delivery_boy_bell_icon_notification',compact('class_name','city_data'));
    }

    public function bell_icon_notification_action(Request $request)
    {
        $this->validate($request, [
           'notification_title' => 'required','user_type' => 'required','city_id' => 'required|numeric'
        ]);
    
        $formdata = $request->all();

        if($formdata['user_type'] == 'user' || $formdata['user_type'] == 'vendor' || $formdata['user_type'] == 'delivery_boy'){

            $filename = '';
            if($request->has('notification_image')){
                $filename = time().'_'.$request->file('notification_image')->getClientOriginalName();
                $filePath = $request->file('notification_image')->storeAs('public/bell_icon_notification_image/'.$formdata['user_type'],$filename);  
            }
            else{
                $filePath = "";
            }

            $formdata['notification_image_name']   = $filePath;
            $formdata['created_by']   = session()->get('*$%&%*id**$%#');
            $formdata['created_ip_address']   = $request->ip();
            $formdata['created_user_type']   = "super_admin";
            $formdata['category_type_id']   = NULL;
            $formdata['category_type']   = NULL;
            
            // function used for add single array 
            $Md_bell_icon_notification_master = Md_bell_icon_notification_master::create($formdata);
            
            if($formdata['user_type'] == 'user'){ $redirect_url = "user.bell.notification";}
            if($formdata['user_type'] == 'vendor'){ $redirect_url = "vendor.bell.notification";}
            if($formdata['user_type'] == 'delivery_boy'){ $redirect_url = "delivery.boy.bell.notification";}

            if(!empty($Md_bell_icon_notification_master->id)){
                return redirect()->route($redirect_url)->with('message', 'Notification send succesfully ');
            }else{
                return redirect()->route($redirect_url)->with('error', 'Notification not send ');
            }
        }else{
            return redirect()->route($redirect_url)->with('error', 'Something went wrong ');
        }
    }


    public function bell_icon_notification_data_table(Request $request,$user_type)
    {
         if ($request->ajax()) {
            
            $data = Md_bell_icon_notification_master::where('status', '<>', 3)->select('notification_title', 'id', 'created_at','message')->where('user_type',$user_type)->where('created_by',session()->get('*$%&%*id**$%#'))->get();
            $data->redirect_url = '';
            if($user_type == 'user'){
               $data->redirect_url = Crypt::encryptString('user.bell.notification'); 
            }
            if($user_type == 'vendor'){ $data->redirect_url = Crypt::encryptString("vendor.bell.notification");}
            if($user_type == 'delivery_boy'){ $data->redirect_url = Crypt::encryptString("delivery.boy.bell.notification");}
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                    $btn = ' <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" flash="Notification" table="' . Crypt::encryptString('mangao_bell_icon_notification_master') . '" redirect-url="' . $data->redirect_url . '" title="Delete" ><i class="fa fa-trash"></i></a> ';
                    return $btn;
                })
                
                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data->created_at));
                    return $date_with_format;
                })

                
                ->rawColumns(['date'])
                ->rawColumns(['action-js']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }
    }
}
