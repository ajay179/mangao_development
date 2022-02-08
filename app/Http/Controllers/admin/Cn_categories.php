<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\Md_mangao_categories;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use DB;
use Config;

class Cn_categories extends Controller
{
    /**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function index()
    {
        $class_name ='Cn_categories';
        return view('admin/categories-banner-section/category_master',compact('class_name'));
    }

     /**
     * This are used to add category Action .
     *
     * @return \Illuminate\Http\Response
     */
    public function categoryAction(Request $request)
    {
       $this->validate($request, [
            'category_ui' => 'required','category_name' => 'required','category_position' => 'required'
        ]);
        
        // function used for add single array 
        $Md_mangao_categories = new Md_mangao_categories;
        if(!empty($request->txtpkey)){
            $msg = "updated";
            $txtpkey =  Crypt::decryptString($request->txtpkey);
            $data = Md_mangao_categories::where('id', $txtpkey)->get();
            if($data->isEmpty()){
                return redirect()->route('main.categories')->with('message', 'something went wrong');
            }else{
                $Md_mangao_categories = Md_mangao_categories::find($txtpkey);
                $Md_mangao_categories->updated_at   = date('Y-m-d h:i:s');
                $Md_mangao_categories->updated_by   = session()->get('*$%&%*id**$%#');
                $Md_mangao_categories->updated_ip_address   = $request->ip();
            }
        }else{
            $msg = "Added";
            $Md_mangao_categories->created_at   = date('Y-m-d h:i:s');
            $Md_mangao_categories->created_by   = session()->get('*$%&%*id**$%#');
            $Md_mangao_categories->created_ip_address   = $request->ip();
        }      
        $filename = '';
        if($request->has('category_image')){
            $filename = time().'_'.$request->file('category_image')->getClientOriginalName();
            $filePath = $request->file('category_image')->storeAs('public/category_image',$filename);  
        }else{
            $filePath = $request->admin_image_old;
        }
        $Md_mangao_categories->category_ui   = $request->category_ui;
        $Md_mangao_categories->category_name   = $request->category_name;
        $Md_mangao_categories->category_position   = $request->category_position;
        $Md_mangao_categories->category_image   = $filePath;
        $Md_mangao_categories->save();

        // this statement are used for getting the last inserted id
       //  $Md_city_master->id;   

        return redirect()->route('main.categories')->with('message', 'Categories '. $msg);
    }

}
