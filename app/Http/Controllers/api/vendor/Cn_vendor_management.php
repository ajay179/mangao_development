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
use App\Models\vendor\Md_sub_category_master; 


class Cn_vendor_management extends Cn_base_controller
{
    /**
     * This function are used get grocery vendor list on there category id.
     *
     * @return \Illuminate\Http\Response
     */
    public function fun_get_grocery_vendor_details(Request $request)
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

        $vendor_product_list= Md_mangao_product_type_master::from('mangao_product_type_master as MPTM')->where('MPTM.status','=', 1)->with(['product_list_of_product_type' => 
            function($query) use ($request)
            {
                $query->where('mangao_vendor_product.vendor_id', '=', $request->vendor_id)->where('mangao_vendor_product.category_type', '=', $request->category_id);

            }])->select('MPTM.product_type_name','MPTM.id')->get();
        
        $collection = collect($vendor_product_list);
        $collection->map(function ($collection) { 
            $sub_arry = collect($collection['product_list_of_product_type']);
            $sub_arry->map(function ($sub_arry) { 
                $sub_arry['wishlist_status'] = 'false'; 
                 return $sub_arry;
            }); 
        });

        $response = [
            'my_banner_list' => $banner_list,
            'venodr_details' => $vendor_details,
            'vendor_category_list' => $vendor_category_list,
            'vendor_product_list' => $collection,

        ];
            return $this->sendResponse($response, 'Data List Found successfully.');
    }


     /**
     * This function are used get restaurant vendor list on there category id.
     *
     * @return \Illuminate\Http\Response
     */
    public function fun_get_restaurant_vendor_details(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|numeric',
            // 'category_type' => 'required|in:Grocery,Restaurant,Pharmacy,Parcel,other',
            'category_type' => 'required|in:Restaurant',
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

        $vendor_product_list= Md_sub_category_master::from('mangao_vendor_sub_category_master as MVSCM')->where('MVSCM.status','=', 1)
                                ->where('MVSCM.category_id','=', $request->category_id)
                                ->where('MVSCM.category_type','=', $request->category_type)
                                ->where('MVSCM.vendor_id','=', $request->vendor_id)
                                ->with(['product_list_of_resto_subcategory' => 
                                    function($query) use ($request)
                                    {
                                        $query->where('mangao_vendor_restaurant_product.vendor_id', '=', $request->vendor_id)->where('mangao_vendor_restaurant_product.category_type', '=', $request->category_id);

                                    }])
                                ->select('MVSCM.vendor_sub_category_name','MVSCM.id');

        if(!empty($request->vendor_category_id)){
            $vendor_product_list=$vendor_product_list->where('MVSCM.vendor_category_id','=', $request->vendor_category_id);
        }else{
            $vendor_product_list=$vendor_product_list->limit('20');
        }

        $vendor_product_list=$vendor_product_list->get();
        
        
        $response = [
            'my_banner_list' => $banner_list,
            'venodr_details' => $vendor_details,
            'vendor_category_list' => $vendor_category_list,
            'vendor_product_list' => $vendor_product_list,

        ];
            return $this->sendResponse($response, 'Data List Found successfully.');
    }


    /**
     * This function are used get Pharmacy vendor list on there category id.
     *
     * @return \Illuminate\Http\Response
     */
    public function fun_get_pharmacy_vendor_details(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|numeric',
            // 'category_type' => 'required|in:Grocery,Restaurant,Pharmacy,Parcel,other',
            'category_type' => 'required|in:Pharmacy',
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

        $vendor_product_list= Md_sub_category_master::from('mangao_vendor_sub_category_master as MVSCM')->where('MVSCM.status','=', 1)
                                ->where('MVSCM.category_id','=', $request->category_id)
                                ->where('MVSCM.category_type','=', $request->category_type)
                                ->where('MVSCM.vendor_id','=', $request->vendor_id)
                                ->with(['product_list_of_pharmacy_subcategory' => 
                                    function($query) use ($request)
                                    {
                                        $query->where('mangao_vendor_pharmacy_product.vendor_id', '=', $request->vendor_id)->where('mangao_vendor_pharmacy_product.category_type', '=', $request->category_id);

                                    }])
                                ->select('MVSCM.vendor_sub_category_name','MVSCM.id');

        if(!empty($request->vendor_category_id)){
            $vendor_product_list=$vendor_product_list->where('MVSCM.vendor_category_id','=', $request->vendor_category_id);
        }else{
            $vendor_product_list=$vendor_product_list->limit('20');
        }

        $vendor_product_list=$vendor_product_list->get();
        
        
        $response = [
            'my_banner_list' => $banner_list,
            'venodr_details' => $vendor_details,
            'vendor_category_list' => $vendor_category_list,
            'vendor_product_list' => $vendor_product_list,

        ];
        return $this->sendResponse($response, 'Data List Found successfully.');
    }
}
