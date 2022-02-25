<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Md_mangao_redeem_point;
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

}
