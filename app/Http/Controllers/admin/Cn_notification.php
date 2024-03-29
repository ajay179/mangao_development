<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Illuminate\Support\Arr;
use App\Models\Md_mangao_time_slot_master;
use App\Models\Md_mangao_admin_send_notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use DB;
use Config;
use Validator;

class Cn_notification extends Controller
{
    
    public function fun_user_notification()
    {
        $slot_list_data = Md_mangao_time_slot_master::where('status','<>','3')->where('slot_category','on_screen_notification_promotion')->select('id','slot_name')->get();
        $class_name = "cn_notification";
        return view('admin/notification/vw_user_notification',compact('class_name','slot_list_data'));
    }

    public function fun_vendor_notification()
    {
        $slot_list_data = Md_mangao_time_slot_master::where('status','<>','3')->where('slot_category','on_screen_notification_promotion')->select('id','slot_name')->get();
        $class_name = "cn_notification";
        return view('admin/notification/vw_vendor_notification',compact('class_name','slot_list_data'));
    }

    public function fun_delivery_boy_notification()
    {
        $slot_list_data = Md_mangao_time_slot_master::where('status','<>','3')->where('slot_category','on_screen_notification_promotion')->select('id','slot_name')->get();
        $class_name = "cn_notification";
        return view('admin/notification/vw_delivery_boy_notification',compact('class_name','slot_list_data'));
    }

    public function fun_vendor_on_screen_notification_add_for_user()
    {
        $class_name = "cn_notification";
        return view('admin/notification/vw_vendor_on_screen_notification_for_user',compact('class_name'));
    }

    /**
     * This is Add Notification action of all notification.
     *
     * @return \Illuminate\Http\Response
     */
    public function userNotificationAction(Request $request)
    {
        $this->validate($request, [
           'notification_title' => 'required','user_type' => 'required'
        ]);
        // return $request->all();
        
        $formdata = $request->all();

        // return $formdata;

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
            $formdata['schedule_date']   = date('Y-m-d',strtotime($formdata['schedule_date']));
            $formdata['created_at']   = date('Y-m-d h:i:s');
            $formdata['created_by']   = session()->get('*$%&%*id**$%#');
            $formdata['created_ip_address']   = $request->ip();
            $formdata['created_user_type']   = "super_admin";
            $formdata['approved_status']   = "approved";
            $formdata['category_type_id']   = NULL;
            $formdata['category_type']   = NULL;
            
            // function used for add single array 
            $Md_mangao_admin_send_notification = Md_mangao_admin_send_notification::create($formdata);
            
            if($formdata['user_type'] == 'user'){ $redirect_url = "user.notification";}
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




    /**
     * This is data table of user notification.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_data_table_of_notification(Request $request,$user_type)
    {
        if ($request->ajax()) {
            
            $data = Md_mangao_admin_send_notification::where('status', '<>', 3)->select('notification_title', 'id', 'created_at','message')->where('user_type',$user_type)->where('created_by',session()->get('*$%&%*id**$%#'))->get();
            $data->redirect_url = '';
            if($user_type == 'user'){
               $data->redirect_url = Crypt::encryptString('user-notification'); 
            }
            if($user_type == 'vendor'){ $data->redirect_url = Crypt::encryptString("vendor.notification");}
            if($user_type == 'delivery_boy'){ $data->redirect_url = Crypt::encryptString("delivery.boy.notification");}
            
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

    public function get_data_table_of_notification_added_vendor(Request $request,$user_type)
    {
        if ($request->ajax()) {
            
            $data = Md_mangao_admin_send_notification::where('status', '<>', 3)->select('notification_title', 'id', 'created_at','message','from_time','to_time','slot_name','notification_image_name','approved_status')->where('user_type',$user_type)->where('created_user_type','=','vendor')->get();

            // return $data;
            $data->redirect_url = '';
            if($user_type == 'user'){
               $data->redirect_url = Crypt::encryptString('user-notification'); 
            }
            if($user_type == 'vendor'){ $data->redirect_url = Crypt::encryptString("vendor.notification");}
            if($user_type == 'delivery_boy'){ $data->redirect_url = Crypt::encryptString("delivery.boy.notification");}
            
            return Datatables::of($data)

                

                ->addIndexColumn()
                ->addColumn('action-js', function($data){

                    // $btn = '<button data-id="' . Crypt::encryptString($data->id) . '" class="btn ';
                    //     if($data->approved_status == 'not_approved'){ $btn .=  'btn-danger ';} 
                    //     if($data->approved_status == 'approved'){ $btn .=  'btn-primary ';}
                    // $btn .=' approvel-btn-status "> ';
                    //      if($data->approved_status == 'not_approved'){  $btn .=  "Not Approved"; }
                    //      if($data->approved_status == 'approved') { $btn .=  "Approved";} 
                    // $btn .= '</button> ';
                    $not_approved_status = '';
                    $approved_status = '';
                    $pending_status = '';
                    $status_color = '';
                    if($data->approved_status == 'not_approved') { 
                      $not_approved_status = "selected";
                      $status_color = "style='color:red;'";
                    } 
                    if($data->approved_status == 'approved') { 
                      $approved_status = "selected";
                      $status_color = "style='color:green;'";
                    } 
                    if($data->approved_status == 'pending') { 
                      $pending_status = "selected";
                      $status_color = "style='color:blue;'";
                    } 
                    $approved_status = ($data->approved_status == 'approved') ?   "selected" : '';
                    $pending_status = ($data->approved_status == 'pending') ?   "selected" : '';


                    $not_approved_status = ($data->approved_status == 'not_approved') ? "selected" : ''; 
                    $approved_status = ($data->approved_status == 'approved') ?   "selected" : '';
                    $pending_status = ($data->approved_status == 'pending') ?   "selected" : '';

                    $btn="<select class='approvel-btn-status form-control' ".$status_color."  data-id='" . Crypt::encryptString($data->id) . "'>
                        <option value='pending' ".$pending_status.">Pending</option>
                        <option value='approved' ".$approved_status.">Approved</option>
                        <option value='not_approved' ".$not_approved_status.">Not Approved</option>
                        </select>";
                    return $btn;
                })
                
                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data->created_at));
                    return $date_with_format;
                })
                ->addColumn('notification_image_name', function($data){
                    return $admin_img = "<img src='".$data->notification_image_name."' height='80px' width='80px' />";
                })

                
                ->rawColumns(['date'])
                ->rawColumns(['action-js','notification_image_name']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }
    }


    public function check_on_screen_notification_slot_and_approved(Request $request)
    {
         if ($request->ajax()) {
            try {
                $notification_id =   Crypt::decryptString($request->notification_id);
               
                $notification_data = Md_mangao_admin_send_notification::where('id', $notification_id)
                    ->where('status', '<>', 3)->where('created_user_type','=','vendor')
                    ->select('schedule_date','from_time','to_time','slot_id','approved_status')
                    ->get();

                if($notification_data->isEmpty()){
                    $message = [
                        'message' =>  'This notification Not Found.',
                        'status' => false,
                    ];
                    return response()->json($message);
                }else{
                    $notification_check_already_approved = Md_mangao_admin_send_notification::where('id', $notification_data[0]->schedule_date)
                        ->where('status', '<>', 3)->where('created_user_type','=','vendor')->where('from_time',$notification_data[0]->from_time)
                        ->where('to_time',$notification_data[0]->to_time)->where('slot_id',$notification_data[0]->slot_id)
                        ->where('approved_status','approved')
                        ->get();

                        if($notification_check_already_approved->isNotEmpty()){
                            $message = [
                                'message' =>  'This slot is already booked.',
                                'status' => false,
                            ];
                        return response()->json($message);
                    }else{
                        $update_bool = Md_mangao_admin_send_notification::where('id', $notification_id)->update(['approved_status' => $request->notification_status_value,'admin_not_approved_remark' => $request->admin_not_approved_remark]);
                        $message = [
                            'message' =>  "Notification approved successfully.",
                            'status' => true,
                        ];
                        return response()->json($message);
                    }     
                }
            } catch (DecryptException $e) {
                return redirect('view-vendor-on-screen-notification-add-for-user')->with('error', 'something went wrong');
            }
        }else{
            exit('No direct script access allowed');
        }

    }

    


}
