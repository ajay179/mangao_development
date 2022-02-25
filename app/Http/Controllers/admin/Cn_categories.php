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

        $check_duplicate_categories = Md_mangao_categories::where('category_name', $request->category_name);
        if(!empty($request->txtpkey)){
          $check_duplicate_categories =  $check_duplicate_categories->where('id','<>', Crypt::decryptString($request->txtpkey));
        }
        $check_duplicate_categories = $check_duplicate_categories->where('status','<>', 3)->get();
        if($check_duplicate_categories->isNotEmpty()){
            return redirect()->route('city')->with('error', 'This city already added.');
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
                    $url =Storage::url($data['category_image']);
                    return $category_image = "<img src=".url($url)."  width='100%' />";
                })
                ->rawColumns(['date'])
                ->rawColumns(['action','category_image'])
                ->make(true);
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


}
