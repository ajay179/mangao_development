<?php

namespace App\Http\Controllers\api\home_controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\api\Cn_base_controller as Cn_base_controller;
use Validator;
use App\Models\User;
use App\Models\Md_mangao_banner;
use App\Models\Md_mangao_categories;
use App\Models\vendor\Md_vendor_category_master;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Arr;
use Config;

class Cn_home_controller extends Cn_base_controller
{
     /**
     * This function are used to store user mobile no and send otp to this mobile no.
     *
     * @return \Illuminate\Http\Response
     */
    public function fun_home_page(Request $request)
    {
        if(!empty($this->verifiedAppToken($request)) && $this->verifiedAppToken($request) != false){
            $validator = Validator::make($request->all(), [
                'limit' => 'required|numeric',
            ]);
       
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors(),'401');       
            } 
            $banner_list= Md_mangao_banner::where('status','=', 1)->select('banner_image','id')-> orderBy('banner_position', 'asc')->get();
            $category_list= Md_mangao_categories::where('status','=', 1)->select('category_ui','category_name','category_image','id')-> orderBy('category_position', 'asc')->get();
            $vendor_category_list= Md_vendor_category_master::where('status','=', 1)->select('vendor_category_name','vendor_category_image','category_type','id')->inRandomOrder()->limit(7)->get();
            $response = [
                'banner_list' => $banner_list,
                'category_list' => $category_list,
                'vendor_category_list' => $vendor_category_list
            ];
             return $this->sendResponse($response, 'User OTP verification successfully.');
        }else{
            return $this->sendError('User Not Authenticate.', "",'403');
        }
    }

    
}


   
