<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Config;
use DB;


class Cn_reward_redeem_points extends Controller
{
    /**
     * This are used to load the view of redeem points .
     *
     * @return \Illuminate\Http\Response
     */
    public function fun_redeem_point()
    {
        $redeem_point_details = DB::table(Config::get('constants.MANGAO_REDEEM_POINTS').'  as MRP')->where('MRP.status', '<>', 3)->select('MRP.reward_points','MRP.value', 'MRP.id')->get();
        if(!empty($redeem_point_details[0]->id)){
            $redeem_point_details[0]->id = Crypt::encryptString($redeem_point_details[0]->id);
        }
            

        return view('admin/reward_redeem_points/vw_redeem_points',compact('redeem_point_details'));
    }
}
