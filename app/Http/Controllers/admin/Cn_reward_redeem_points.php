<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Md_mangao_redeem_point;
use App\Models\Md_mangao_app_refer;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use DB;
use Config;



class Cn_reward_redeem_points extends Controller
{
    /**
     * This are used to load the view of redeem points .
     *
     * @return \Illuminate\Http\Response
     */
    public function fun_redeem_point()
    {
        $redeem_point_details = DB::table(Config::get('constants.MANGAO_REDEEM_POINTS').'  as MRP')->where('MRP.status', '<>', 3)->where('MRP.points_type', '=', 'Reedem Points')->select('MRP.reward_points','MRP.value', 'MRP.id')->get();
        if(!empty($redeem_point_details[0]->id)){
            $redeem_point_details[0]->id = Crypt::encryptString($redeem_point_details[0]->id);
        }
            

        return view('admin/reward_redeem_points/vw_redeem_points',compact('redeem_point_details'));
    }

    public function fun_reward_point()
    {
        $redeem_point_details = DB::table(Config::get('constants.MANGAO_REDEEM_POINTS').'  as MRP')->where('MRP.status', '<>', 3)->where('MRP.points_type', '=', 'Reward Points')->select('MRP.reward_points','MRP.value', 'MRP.id')->get();
        if(!empty($redeem_point_details[0]->id)){
            $redeem_point_details[0]->id = Crypt::encryptString($redeem_point_details[0]->id);
        }
            

        return view('admin/reward_redeem_points/vw_reward_points',compact('redeem_point_details'));
    }


    public function fun_app_refer()
    {
        $app_refer_details = DB::table('mangao_app_refer_setting  as MRP')->where('MRP.status', '<>', 3)->select('MRP.welcome_coins','MRP.welcome_coins_text', 'MRP.id')->get();
        if(!empty($app_refer_details[0]->id)){
            $app_refer_details[0]->id = Crypt::encryptString($app_refer_details[0]->id);
        }
            

        return view('admin/reward_redeem_points/vw_app_refer',compact('app_refer_details'));
    }

    

      /**
     * This are used to add About Us Action .
     *
     * @return \Illuminate\Http\Response
     */
    public function cmsPointsAction(Request $request)
    {
       $this->validate($request, [
           'points_type' => 'required','reward_points' => 'required','value' => 'required'
        ]);

        
        // function used for add single array 
        $Md_mangao_redeem_point = new Md_mangao_redeem_point;
        
            if(!empty($request->txtpkey)){
            $msg = "updated";
            $txtpkey =  Crypt::decryptString($request->txtpkey);
            $data = Md_mangao_redeem_point::where('id', $txtpkey)->get();
            if($data->isEmpty()){
                return redirect()->back()->with('message', 'something went wrong');
            }else{

                $Md_mangao_redeem_point = Md_mangao_redeem_point::find($txtpkey);
                $Md_mangao_redeem_point->updated_at   = date('Y-m-d h:i:s');
                $Md_mangao_redeem_point->updated_by   = session()->get('*$%&%*id**$%#');
                $Md_mangao_redeem_point->updated_ip_address   = $request->ip();
            }
        }else{
            $msg = "Added";
            $Md_mangao_redeem_point->created_at   = date('Y-m-d h:i:s');
            $Md_mangao_redeem_point->created_by   = session()->get('*$%&%*id**$%#');
            $Md_mangao_redeem_point->created_ip_address   = $request->ip();
        }      
       
        $Md_mangao_redeem_point->points_type   = $request->points_type;
        $Md_mangao_redeem_point->reward_points   = $request->reward_points;
        $Md_mangao_redeem_point->value   = $request->value;
        $Md_mangao_redeem_point->save();

        // this statement are used for getting the last inserted id
       //  $Md_mangao_banner->id;   

        return redirect()->back()->with('message', ' Reward / Reedem Points '. $msg);
    }


    public function fun_app_refer_points_action(Request $request)
    {
         $this->validate($request, [
           'welcome_coins' => 'required','welcome_coins_text' => 'required'
        ]);

        
        // function used for add single array 
        $Md_mangao_app_refer = new Md_mangao_app_refer;
        
            if(!empty($request->txtpkey)){
            $msg = "updated";
            $txtpkey =  Crypt::decryptString($request->txtpkey);
            $data = Md_mangao_app_refer::where('id', $txtpkey)->get();
            if($data->isEmpty()){
                return redirect()->back()->with('message', 'something went wrong');
            }else{

                $Md_mangao_app_refer = Md_mangao_app_refer::find($txtpkey);
                $Md_mangao_app_refer->updated_at   = date('Y-m-d h:i:s');
                $Md_mangao_app_refer->updated_by   = session()->get('*$%&%*id**$%#');
                $Md_mangao_app_refer->updated_ip_address   = $request->ip();
            }
        }else{
            $msg = "Added";
            $Md_mangao_app_refer->created_at   = date('Y-m-d h:i:s');
            $Md_mangao_app_refer->created_by   = session()->get('*$%&%*id**$%#');
            $Md_mangao_app_refer->created_ip_address   = $request->ip();
        }      
       
        $Md_mangao_app_refer->welcome_coins   = $request->welcome_coins;
        $Md_mangao_app_refer->welcome_coins_text   = $request->welcome_coins_text;
        $Md_mangao_app_refer->save();

        // this statement are used for getting the last inserted id
       //  $Md_mangao_banner->id;   

        return redirect()->back()->with('message', ' App Refer Points '. $msg);

    }
}
