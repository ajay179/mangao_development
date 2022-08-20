<?php

namespace App\Http\Controllers\vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Md_mangao_time_slot_master;
use App\Models\Md_mangao_admin_send_notification;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
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
                $filePath = $request->file('notification_image')->storeAs('public/on_screen_notification_image/'.$formdata['user_type'],$filename);  
            }
            else{
                $filePath = "";
            }

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
            
            // return $formdata;
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


    public function vendorGetOnScreenNotificationDataTable(Request $request,$user_type)
    {
       if ($request->ajax()) {
            
            $data = Md_mangao_admin_send_notification::where('status', '<>', 3)->select('notification_title', 'id', 'created_at','message')->where('user_type',$user_type)->where('created_by',session()->get('*$%&%*id**$%#'))->get();
            $data->redirect_url = '';
            if($user_type == 'user'){
               $data->redirect_url = Crypt::encryptString('user-notification'); 
            }
            if($user_type == 'vendor'){ $data->redirect_url = "vendor.notification";}
            if($user_type == 'delivery_boy'){ $data->redirect_url = "delivery.boy.notification";}
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                    $btn = ' <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" flash="Notification" table="' . Crypt::encryptString('mangao_admin_send_notification') . '" redirect-url="' . $data->redirect_url . '" title="Delete" ><i class="fa fa-trash"></i></a> ';
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
