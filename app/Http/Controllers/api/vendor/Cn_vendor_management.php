<?php

namespace App\Http\Controllers\api\vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\api\Cn_base_controller as Cn_base_controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Config;
use Validator;
use App\Models\vendor\Md_mangao_vendor_banner;
use App\Models\Md_city_admin_vendor;
use App\Models\Md_mangao_product_type_master;
use App\Models\vendor\Md_vendor_category_master;

class Cn_vendor_management extends Cn_base_controller
{
    /**
     * This function are used get all vendor list on there category id.
     *
     * @return \Illuminate\Http\Response
     */
    public function fun_get_vendor_details(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|numeric',
            // 'category_type' => 'required|in:Grocery,Restaurant,Pharmacy,Parcel,other',
            'category_type' => 'required|in:Grocery',
            'vendor_id' => 'required|numeric',
            'limit' => 'required|numeric',
            'offset' => 'required|numeric',
        ]);
    
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(),'401');       
        } 
        $banner_list= Md_mangao_vendor_banner::where('status','=', 1)->where('vendor_id','=', $request->vendor_id)->where('category_id','=', $request->category_id)->where('category_type','=', $request->category_type)->select('vendor_banner_img','id')-> orderBy('id', 'desc')->get();

        $vendor_details= Md_city_admin_vendor::where('status','=', 1)->where('id','=', $request->vendor_id)->where('category_id','=', $request->category_id)->where('category_type','=', $request->category_type)->select('store_owner_name','id','created_at','vendor_latitude','vendor_longitude','delivery_range','vendor_image')->first();
        $vendor_details['star_rating'] = '3.5';
        $vendor_details['user_rating_count'] = '10';
        $vendor_details['offer_status'] = false; 
        $vendor_details['wishlist_status'] = false; 

        $vendor_category_list= Md_vendor_category_master::where('status','=', 1)->where('vendor_id','=', $request->vendor_id)->where('category_id','=', $request->category_id)->where('category_type','=', $request->category_type)->select('vendor_category_name','vendor_category_image','id')->orderBy('id', 'desc')->get();

        $vendor_product_list= Md_mangao_product_type_master::where('status','=', 1)->with(['product_list_of_product_type' => 
            function($query) use ($request)
            {
                $query->where('vendor_id', '=', $request->vendor_id)->where('category_type', '=', $request->category_id);

            }])->select('product_type_name','id')->get();
        
        $response = [
            'my_banner_list' => $banner_list,
            'venodr_details' => $vendor_details,
            'vendor_category_list' => $vendor_category_list,
            'vendor_product_list' => $vendor_product_list,

        ];
            return $this->sendResponse($response, 'Data List Found successfully.');
    }
}
