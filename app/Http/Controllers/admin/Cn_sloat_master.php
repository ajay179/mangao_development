<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Md_mangao_time_slot_master;
use DataTables;

class Cn_sloat_master extends Controller
{
    /**
     * Banner slot master.
     *
     * @return \Illuminate\Http\Response 
     */
    public function fun_banner_slot()
    {
        $slot_category =  Crypt::encryptString('banner_promotion');
        return view('admin/slot-master/banner_slot_master',compact('slot_category'));
    }
    public function fun_vendor_promotion_slot()
    {
        $slot_category =  Crypt::encryptString('vendor_promotion');
        return view('admin/slot-master/vendor_promotion_slot_master',compact('slot_category'));
    }
    public function fun_notification_slot()
    {
        $slot_category =  Crypt::encryptString('notification_promotion');
        return view('admin/slot-master/notification_promotion_slot_master',compact('slot_category'));
    }

    public function fun_on_screen_notification_slot()
    {
        $slot_category =  Crypt::encryptString('on_screen_notification_promotion');
        return view('admin/slot-master/on_screen_notification_promotion_slot_master',compact('slot_category'));
    }

    public function fun_time_slot_master_action(Request $request)
    {
         $this->validate($request, [
            'slot_name' => 'required','slot_category' => 'required','from_time' => 'required','to_time' => 'required'
        ]);
        
        $formdata = $request->all();
         $redirect_url = "";
        if(Crypt::decryptString($formdata['slot_category']) == 'banner_promotion'){ $redirect_url = "banner.slot.master"; }
        if(Crypt::decryptString($formdata['slot_category']) == 'vendor_promotion'){ $redirect_url = "vendor.promotion.slot.master";}
        if(Crypt::decryptString($formdata['slot_category']) == 'notification_promotion'){ $redirect_url = "notification.slot.master";}
        if(Crypt::decryptString($formdata['slot_category']) == 'on_screen_notification_promotion'){ $redirect_url = "on.screen.notification.slot.master";}

        if(!empty($formdata['txtpkey'])){
            $msg = "updated";
            $txtpkey =  Crypt::decryptString($formdata['txtpkey']);
            $data = Md_mangao_time_slot_master::where('id', $txtpkey)->get();
            if($data->isEmpty()){
                return redirect()->route('banner.slot.master')->with('message', 'something went wrong');
            }else{
                $formdata['updated_by']   = session()->get('&&*id$##');
                $formdata['from_time']   = date('H:i:s',strtotime($formdata['from_time']));
                $formdata['to_time']   = date('H:i:s',strtotime($formdata['to_time']));
                $formdata['updated_ip_address']   = $request->ip();
                $formdata = Arr::except($formdata,['_token','txtpkey','product_image_old']);
                $Md_mangao_categories = Md_mangao_time_slot_master::where('id',$txtpkey)->update($formdata);
            }
        }else{
            $msg = "Added";
            $formdata['created_by']   = session()->get('&&*id$##');
            $formdata['from_time']   = date('H:i:s',strtotime($formdata['from_time']));
            $formdata['to_time']   = date('H:i:s',strtotime($formdata['to_time']));
            $formdata['slot_category']   = Crypt::decryptString($formdata['slot_category']);
            $formdata['created_ip_address']   = $request->ip();
            $Md_mangao_categories = Md_mangao_time_slot_master::create($formdata);
        }      
       
        return redirect()->route($redirect_url)->with('message', 'Time slot '. $msg);
    }


    

    public function fun_time_slot_master_get_data_table(Request $request,$slot_type)
    {
        if ($request->ajax()) {
            
            $data = Md_mangao_time_slot_master::where('status', '<>', 3)->select('slot_name', 'id', 'created_at','from_time','to_time')->where('slot_category',$slot_type)->get();
            $data->redirect_url = '';
            if($slot_type == 'banner_promotion'){ $data->redirect_url = "banner.slot.master"; }
            if($slot_type == 'vendor_promotion'){ $data->redirect_url = "vendor.promotion.slot.master";}
            if($slot_type == 'notification_promotion'){ $data->redirect_url = "notification.slot.master";}
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $btn = ' <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" flash="Time Slot" table="' . Crypt::encryptString('mangao_time_slot_master') . '" redirect-url="' . $data->redirect_url . '" title="Delete" ><i class="fa fa-trash"></i></a> ';
                    return $btn;
                })
                
                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data->created_at));
                    return $date_with_format;
                })

                
                ->rawColumns(['date'])
                ->rawColumns(['action']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }
    }
}