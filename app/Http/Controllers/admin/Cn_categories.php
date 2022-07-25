<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Md_mangao_categories;
use App\Models\Md_mangao_store_type_master;
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
     * Display a listing of the store type.
     *
     * @return \Illuminate\Http\Response
     */
    public function fun_store_type_master()
    {
       $class_name ='Cn_categories';
       $vendor_data = Md_mangao_categories::latest()->where('status','<>',3)->select('category_name','id','created_at')->get();
        return view('admin/categories-banner-section/store_type_master',compact('class_name','vendor_data'));
    }

     /**
     * function to view store type edit view.
     *
     * @return \Illuminate\Http\Response
     */
    public function fun_edit_store_type_master($encrypt_id)
    {
        try {
            
            $id =  Crypt::decryptString($encrypt_id);
            $store_type_master_details = DB::table('mangao_store_type_master  as MSTM')->where('MSTM.status', '<>', 3)->where('MSTM.id', '=', $id)->select('MSTM.store_category_id','MSTM.store_type_name','MSTM.id')->get();

            $store_type_master_details[0]->id = Crypt::encryptString($store_type_master_details[0]->id);
            $class_name ='cn_categories';
            
            if(!empty($store_type_master_details[0])){
                $vendor_data = Md_mangao_categories::latest()->where('status','<>',3)->select('category_name','id','created_at')->get();
                return view('admin/categories-banner-section/store_type_master',compact('class_name','vendor_data','store_type_master_details'));
            }else{
               return redirect('view-store-type')->with('error', 'something went wrong');
            }
        } catch (DecryptException $e) {
            return redirect('view-store-type')->with('error', 'something went wrong');
        }

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

        $check_duplicate_categories = Md_mangao_categories::where('category_name', $request->category_name);
        if(!empty($request->txtpkey)){
          $check_duplicate_categories =  $check_duplicate_categories->where('id','<>', Crypt::decryptString($request->txtpkey));
        }
        $check_duplicate_categories = $check_duplicate_categories->where('status','<>', 3)->get();
        if($check_duplicate_categories->isNotEmpty()){
            return redirect()->route('main.categories')->with('error', 'This category already added.');
        }else{
            $check_category_position = Md_mangao_categories::where('category_position',$request->category_position)->where('status','<>','3');
            if(!empty($request->txtpkey)){
                $check_category_position = $check_category_position->where('id','<>', Crypt::decryptString($request->txtpkey));
            }
           $check_category_position = $check_category_position->get();
            if ($check_category_position->isNotEmpty()) {
                 return redirect()->route('main.categories')->with('error', 'This category position already added.');
            }else{

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
            }
            // this statement are used for getting the last inserted id
           //  $Md_city_master->id;   

            return redirect()->route('main.categories')->with('message', 'Categories '. $msg);
        }
    }


    public function get_data_table_of_category(Request $request)
    {
        if ($request->ajax()) {
            $data = Md_mangao_categories::latest()->select('category_ui','category_name','category_position','category_image','id','created_at')->where('status', '<>', 3)->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $btn = '<a href="'. url("/edit-categoryadmin") ."/". Crypt::encryptString($data->id).'" class="edit btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>  <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" flash="Category admin" table="' . Crypt::encryptString('mangao_categories') . '" redirect-url="' . Crypt::encryptString('categories') . '" title="Delete" ><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data['created_at']));
                    return $date_with_format;
                })
                ->addColumn('category_image', function($data){
                    return $category_image = "<img src=".$data['category_image']."  width='100%' />";
                })
                ->rawColumns(['date'])
                ->rawColumns(['action','category_image'])
                ->make(true);
        }

    }

     /**
     * This function are used to check the category position.
     *
     * @return \Illuminate\Http\Response
     */
    public function fun_check_category_position(Request $request)
    {
        if ($request->ajax()) {
            $position_no = $request->category_position;
            if(!empty($position_no)){
                $check_category_position = Md_mangao_categories::where('category_position',$position_no)->where('status','<>','3');
                if(!empty($request->txtpkey)){
                    $category_id = Crypt::decryptString($request->txtpkey);
                    $check_category_position = $check_category_position->where('id','<>',$category_id);
                }
               $check_category_position = $check_category_position->get();
                if ($check_category_position->isEmpty()) {
                    return "true";
                }else{
                    return "false";
                }
            }else{
                return "false";
            }
            
        }else{
            return "false";
        }
    }

    public function fun_edit_category($encrypt_id)
    {
        try {
            
            $id =  Crypt::decryptString($encrypt_id);
            $category_data = DB::table(Config::get('constants.MANGAO_CATEGORY_MASTER').'  as MCM')->where('MCM.status', '<>', 3)->where('MCM.id', '=', $id)->select('MCM.category_ui','MCM.category_name','MCM.category_position','MCM.category_image','MCM.id')->get();

            $category_data[0]->id = Crypt::encryptString($category_data[0]->id);
            $class_name ='cn_categories';
            
            //make image url
            $url =Storage::url($category_data[0]->category_image);
            $category_data[0]->show_category_img = url($url);

            if(!empty($category_data[0])){
                return view('admin/categories-banner-section/category_master',compact('class_name','category_data'));
            }else{
               return redirect('categories')->with('error', 'something went wrong');
            }
        } catch (DecryptException $e) {
            return redirect('categories')->with('error', 'something went wrong');
        }

    }

    /**
     * This are used to add store type Action .
     *
     * @return \Illuminate\Http\Response
     */
    public function fun_store_type_action(Request $request)
    {
       $this->validate($request, [
            'store_category_id' => 'required|numeric','store_type_name' => 'required'
        ]);
        
        // function used for add single array 
        $Md_mangao_store_type_master = new Md_mangao_store_type_master;

        $check_duplicate_store_type = Md_mangao_store_type_master::where('store_type_name', $request->store_type_name);
        if(!empty($request->txtpkey)){
          $check_duplicate_store_type =  $check_duplicate_store_type->where('id','<>', Crypt::decryptString($request->txtpkey));
        }
        $check_duplicate_store_type = $check_duplicate_store_type->where('status','<>', 3)->get();
        if($check_duplicate_store_type->isNotEmpty()){
            return redirect()->route('main.categories')->with('error', 'This store type already added.');
        }else{
           
            if(!empty($request->txtpkey)){
                $msg = "updated";
                $txtpkey =  Crypt::decryptString($request->txtpkey);
                $data = Md_mangao_store_type_master::where('id', $txtpkey)->get();
                if($data->isEmpty()){
                    return redirect()->route('main.categories')->with('message', 'something went wrong');
                }else{
                    $Md_mangao_store_type_master = Md_mangao_store_type_master::find($txtpkey);
                    $Md_mangao_store_type_master->updated_at   = date('Y-m-d h:i:s');
                    $Md_mangao_store_type_master->updated_by   = session()->get('*$%&%*id**$%#');
                    $Md_mangao_store_type_master->updated_ip_address   = $request->ip();
                }
            }else{
                $msg = "Added";
                $Md_mangao_store_type_master->created_at   = date('Y-m-d h:i:s');
                $Md_mangao_store_type_master->created_by   = session()->get('*$%&%*id**$%#');
                $Md_mangao_store_type_master->created_ip_address   = $request->ip();
            }      
           
            $Md_mangao_store_type_master->store_category_id   = $request->store_category_id;
            $Md_mangao_store_type_master->store_type_name   = $request->store_type_name;
            $Md_mangao_store_type_master->save();
        
            return redirect()->route('master.store.type')->with('message', 'Categories '. $msg);
        }
    }

    
    
    public function fun_get_store_type_datatable(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('mangao_store_type_master  as MSTM')
                ->join('mangao_categories as MCM', 'MCM.id','=', 'MSTM.store_category_id')
                ->where('MSTM.status', '<>', 3)
                ->where('MCM.status', '<>', 3)
                ->select('MSTM.store_type_name','MCM.category_name','MSTM.id','MSTM.created_at','MSTM.status')
                ->get();


            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $btn = '<a href="'. url("edit-store-type-master") ."/". Crypt::encryptString($data->id).'" class="edit btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>  <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" flash="Store type" table="' . Crypt::encryptString('mangao_store_type_master') . '" alert_status="3" title="Delete" ><i class="fa fa-trash"></i></a><br>
                    ';
                    return $btn;
                })

                ->addColumn('status', function($data){
                    $status_class = (!empty($data->status)) && ($data->status == 1) ? 'tgle-on' : 'tgle-off'; 
                    $status = '<a href="javascript:void(0);" flash="Store type " status="'.Crypt::encryptString($data->status).'" table="' . Crypt::encryptString('mangao_store_type_master') . '" alert_status="'.$data->status.'"  data-id="' . Crypt::encryptString($data->id) . '"  class="superadmin-change-vendor-status"  > <i class="fa fa-toggle-on '. $status_class.' " aria-hidden="true" title="Active"></i></a>';
                    return $status;
                })
                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data->created_at));
                    return $date_with_format;
                })
            
                ->rawColumns(['date'])
                ->rawColumns(['action','status'])
                ->make(true);
        }

    }

}
