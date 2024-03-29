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
use App\Models\Md_city_admin_vendor;
use App\Models\vendor\Md_mangao_vendor_promotional_banner;
use App\Models\Md_mangao_store_type_master;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Config;
use DB;

class Cn_home_controller extends Cn_base_controller
{
     /**
     * This function are used to get all home page data.
     *
     * @return \Illuminate\Http\Response
     */
    public function fun_home_page(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'limit' => 'required|numeric',
        // ]);
    
        // if($validator->fails()){
        //     return $this->sendError('Validation Error.', $validator->errors(),'401');       
        // } 
        $banner_list= Md_mangao_banner::where('status','=', 1)->select('banner_image','id','banner_name')-> orderBy('banner_position', 'asc')->get();
        $category_list= Md_mangao_categories::where('status','=', 1)->select('category_ui','category_name','category_image','id','category_ui')-> orderBy('category_position', 'asc');
        if(!empty($request->limit) && !empty($request->limit)){
            $category_list = $category_list->offset($request->offset * $request->limit)->limit($request->limit);
        }
        $category_list =  $category_list->get();
        $grocery_id = $this->get_main_category_id('Grocery');
        $restaurant_id = $this->get_main_category_id('Restaurant');
        $pharmacy_id = $this->get_main_category_id('Pharmacy');
        $response = [
            'banner_list' => $banner_list,
            'category_list' => $category_list,
            'grocery_vendor_list' => $this->get_vendor_list($grocery_id,'Grocery'),
            'restaurant_vendor_list' => $this->get_vendor_list($restaurant_id,'Restaurant'),
            'pharmacy_vendor_list' => $this->get_vendor_list($pharmacy_id,'Pharmacy'),
            'other_venddor_list' => $this->get_other_all_vendor_list($grocery_id,$restaurant_id,$pharmacy_id),
            
        ];
            return $this->sendResponse($response, 'Data List Found successfully.');
        
    }


    private function get_vendor_list($category_id='',$category_type='',$store_type_id ='')
    {
        $vendor_list = Md_city_admin_vendor::latest()->select('store_owner_name','id','created_at','vendor_latitude','vendor_longitude','delivery_range','vendor_image','vendor_store_type_name')->where('category_id', '=', $category_id)->where('category_type', '=', $category_type)->where('status', '<>', 3)->get();


        $collection = collect($vendor_list);
        $collection->map(function ($collection) {            
            $collection['star_rating'] = '3.5';
            $collection['user_rating_count'] = '10';
            $collection['offer_status'] = false; 
            $collection['wishlist_status'] = false; 
            return $collection;
        });
        return $collection;

    }

    private function get_main_category_id($category_type='')
    {
        $category_id = Md_mangao_categories::where('status','<>',3)->where('category_ui','=',$category_type)->select('id')->get();
        return $category_id = !empty($category_id[0]->id) ? $category_id[0]->id : '';
    }

   private function get_other_all_vendor_list($grocery_id='',$restaurant_id='',$pharmacy_id='')
    {
        $other_vendor_list = Md_city_admin_vendor::latest()->select('store_owner_name','id','created_at','vendor_latitude','vendor_longitude','delivery_range','vendor_image')->where('category_id', '<>', $grocery_id)->where('category_id', '<>', $restaurant_id)->where('category_id', '<>', $pharmacy_id)->where('status', '<>', 3)->get();
        return $other_vendor_list;
    } 


    public function get_vendor_list_for_perticuler_category($category_id='',$category_type='',$store_type_id ='',$limit='',$offset='')
    {
        $vendor_list = Md_city_admin_vendor::latest()->select('store_owner_name','id','vendor_store_type','created_at','vendor_latitude','vendor_longitude','delivery_range','vendor_image','vendor_store_type_name')->where('category_id', '=', $category_id)->where('category_type', '=', $category_type)->where('status', '<>', 3);

        if(!empty($store_type_id)){
            $vendor_list = $vendor_list->whereRaw('FIND_IN_SET("'.$store_type_id.'", vendor_store_type)');
        }

        $vendor_list = $vendor_list->offset($offset*$limit)->limit($limit)->get();

        $collection = collect($vendor_list);
        $collection->map(function ($collection) {            
            $collection['star_rating'] = '3.5';
            $collection['user_rating_count'] = '10';
            $collection['offer_status'] = false; 
            $collection['wishlist_status'] = false; 
            return $collection;
        });
        return $vendor_list;
    }

     /**
     * This function are used get all vendor list on there category id.
     *
     * @return \Illuminate\Http\Response
     */
    public function fun_get_vendor_listing(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|numeric',
            'category_type' => 'required|in:Grocery,Restaurant,Pharmacy,Parcel,other',
            'limit' => 'required|numeric',
            'offset' => 'required|numeric',
        ]);
    
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(),'401');       
        } 
        $banner_list= Md_mangao_vendor_promotional_banner::where('status','=', 1)->select('promotion_banner_image','id')-> orderBy('id', 'asc')->get();
        $store_type_list= Md_mangao_store_type_master::where('status','=', 1)->where('store_category_id','=', $request->category_id)->select('store_type_name','id')-> orderBy('id', 'asc')->get();

        $store_type_id = !empty($request->store_type_id) ? $request->store_type_id : '';
        $vendor_list= $this->get_vendor_list_for_perticuler_category($request->category_id,$request->category_type,$store_type_id,$request->limit,$request->offset);
        
        $response = [
            'banner_list' => $banner_list,
            'store_type_list' => $store_type_list,
            // 'promotional_vendor_list' => $vendor_list,
            'vendor_list' => $vendor_list,

        ];
            return $this->sendResponse($response, 'Data List Found successfully.');
    }

    
}


   
