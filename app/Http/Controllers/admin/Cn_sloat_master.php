<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Md_mangao_time_slot_master;


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
        return view('admin/slot-master/banner_slot_master',compact('slot_category'));
    }
    public function fun_notification_slot()
    {
        $slot_category =  Crypt::encryptString('notification_promotion');
        return view('admin/slot-master/banner_slot_master',compact('slot_category'));
    }

    public function fun_time_slot_master_action(Request $request)
    {
         $this->validate($request, [
            'slot_name' => 'required','slot_category' => 'required','from_time' => 'required','to_time' => 'required'
        ]);
        
        $formdata = $request->all();
          
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
       
        return redirect()->route('banner.slot.master')->with('message', 'Time slot '. $msg);
    }
}
