<?php

namespace App\Http\Controllers\vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Md_mangao_time_slot_master;
use App\Models\Md_mangao_admin_send_notification;
use Illuminate\Support\Arr;
use DataTables;
use DB;
use Config;
use Validator;

class Cn_vendor_on_screen_notification extends Controller
{
    public function fun_vendor_to_user_notification()
    {
        $slot_list_data = Md_mangao_time_slot_master::where('status','<>','3')->where('slot_category','on_screen_notification_promotion')->select('id','slot_name')->get();
        $class_name = "cn_vendor_on_screen_notification";
        return view('vendor/notification/vw_vendor_to_user_notification',compact('class_name','slot_list_data'));
    }


    /**
     * This is Add Notification action of all notification.
     *
     * @return \Illuminate\Http\Response
     */
    public function vendorToUserNotificationAction(Request $request)
    {
        $this->validate($request, [
           'notification_title' => 'required','user_type' => 'required'
        ]);
        $formdata = $request->all();
        if($formdata['user_type'] == 'user' || $formdata['user_type'] == 'vendor' || $formdata['user_type'] == 'delivery_boy'){

            $filename = '';
            if($request->has('notification_image')){
                $filename = time().'_'.$request->file('notification_image')->getClientOriginalName();
                $filePath = $request->file('notification_image')->storeAs('public/on_screen_notification_image',$filename);  
            }
            // else{
            //     $filePath = $request->admin_image_old;
            // }

            $check_slot_data =  Md_mangao_time_slot_master::where('status','<>','3')->where('slot_category','on_screen_notification_promotion')->select('id','slot_name','from_time','to_time')->first();

            $formdata['notification_image_name']   = $filePath;
            $formdata['slot_id'] = $formdata['time_slot_id'];

            if(!empty($check_slot_data)){
                $formdata['slot_name'] = $check_slot_data->slot_name;
                $formdata['from_time'] = $check_slot_data->from_time;
                $formdata['to_time'] = $check_slot_data->to_time;
            }

            $formdata['created_at']   = date('Y-m-d h:i:s');
            $formdata['created_by']   = session()->get('&&*id$##');
            $formdata['created_ip_address']   = $request->ip();
            $formdata['created_user_type']   = "vendor";
            $formdata['category_type_id']   = session()->get('$%vendor_category_type_id&%*');
            $formdata['category_type']   = session()->get('$%vendor_category_type&%*');
            
            // function used for add single array 
            $Md_mangao_admin_send_notification = Md_mangao_admin_send_notification::create($formdata);
            
            if($formdata['user_type'] == 'user'){ $redirect_url = "on.screen.notification.list";}
            if($formdata['user_type'] == 'vendor'){ $redirect_url = "vendor.notification";}
            if($formdata['user_type'] == 'delivery_boy'){ $redirect_url = "delivery.boy.notification";}

            if(!empty($Md_mangao_admin_send_notification->id)){
                return redirect()->route($redirect_url)->with('message', 'Notification added ');
            }else{
                return redirect()->route($redirect_url)->with('error', 'Notification not added ');
            }
        }else{
            return redirect()->route($redirect_url)->with('error', 'Something went wrong ');
        }
    }

}
