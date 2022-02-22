<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Illuminate\Support\Arr;
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
        $class_name = "cn_notification";
        return view('admin/notification/vw_user_notification',compact('class_name'));
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
        
        $formdata = $request->all();

        if($formdata['user_type'] == 'user' || $formdata['user_type'] == 'vendor' || $formdata['user_type'] == 'delivery_boy'){
            $formdata = Arr::except($formdata,['_token']);
            $formdata['created_at']   = date('Y-m-d h:i:s');
            $formdata['created_by']   = session()->get('*$%&%*id**$%#');
            $formdata['created_ip_address']   = $request->ip();
            
            // function used for add single array 
            $Md_mangao_admin_send_notification = Md_mangao_admin_send_notification::create($formdata);
            
            if(!empty($Md_mangao_admin_send_notification->id)){
                return redirect()->route('user.notification')->with('message', 'Notification added ');
            }else{
                return redirect()->route('user.notification')->with('error', 'Notification not added ');
            }
        }else{
            return redirect()->route('user.notification')->with('error', 'Something went wrong ');
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
            
            $data = Md_mangao_admin_send_notification::where('status', '<>', 3)->select('notification_title', 'id', 'created_at','message')->where('user_type',$user_type)->get();
            $data->redirect_url = '';
            if($user_type == 'user'){
               $data->redirect_url = Crypt::encryptString('user-notification'); 
            }
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
