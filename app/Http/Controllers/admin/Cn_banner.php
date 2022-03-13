<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Md_mangao_banner;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use DB;
use Config;

class Cn_banner extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $class_name ='Cn_banner';
        return view('admin/categories-banner-section/banner_master',compact('class_name'));
    }

    /**
     * This are used to add banner Action .
     *
     * @return \Illuminate\Http\Response
     */
    public function bannerAction(Request $request)
    {
       $this->validate($request, [
           'banner_name' => 'required','banner_position' => 'required'
        ]);
        
        // function used for add single array 
        $Md_mangao_banner = new Md_mangao_banner;
        if(!empty($request->txtpkey)){
            $msg = "updated";
            $txtpkey =  Crypt::decryptString($request->txtpkey);
            $data = Md_mangao_banner::where('id', $txtpkey)->get();
            if($data->isEmpty()){
                return redirect()->route('main.banner')->with('message', 'something went wrong');
            }else{
                $Md_mangao_banner = Md_mangao_banner::find($txtpkey);
                $Md_mangao_banner->updated_at   = date('Y-m-d h:i:s');
                $Md_mangao_banner->updated_by   = session()->get('*$%&%*id**$%#');
                $Md_mangao_banner->updated_ip_address   = $request->ip();
            }
        }else{
            $msg = "Added";
            $Md_mangao_banner->created_at   = date('Y-m-d h:i:s');
            $Md_mangao_banner->created_by   = session()->get('*$%&%*id**$%#');
            $Md_mangao_banner->created_ip_address   = $request->ip();
        }      
        $filename = '';
        if($request->has('banner_image')){
            $filename = time().'_'.$request->file('banner_image')->getClientOriginalName();
            $filePath = $request->file('banner_image')->storeAs('public/banner_image',$filename);  
        }else{
            $filePath = $request->admin_image_old;
        }
        $Md_mangao_banner->banner_name   = $request->banner_name;
        $Md_mangao_banner->banner_position   = $request->banner_position;
        $Md_mangao_banner->banner_image   = $filePath;
        $Md_mangao_banner->save();

        // this statement are used for getting the last inserted id
       //  $Md_mangao_banner->id;   

        return redirect()->route('main.banner')->with('message', 'Banner '. $msg);
    }

     public function get_data_table_of_banner_master(Request $request)
    {
        if ($request->ajax()) {
            $data = Md_mangao_banner::latest()->select('banner_name','banner_position','banner_image','id','created_at')->where('status', '<>', 3)->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $btn = '<a href="'. url("/edit-banner") ."/". Crypt::encryptString($data->id).'" class="edit btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>  <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" flash="Banner" table="' . Crypt::encryptString('mangao_banner_masters') . '" redirect-url="' . Crypt::encryptString('banner') . '" title="Delete" ><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data['created_at']));
                    return $date_with_format;
                })
                ->addColumn('banner_image', function($data){
                    $url =Storage::url($data['banner_image']);
                    return $admin_img = "<img src=".url($url)." height='80px' width='80px' />";
                })
                ->rawColumns(['date'])
                ->rawColumns(['action','banner_image'])
                ->make(true);
        }

    }

    public function fun_edit_banner($encrypt_id)
    {
        try {
            
            $id =  Crypt::decryptString($encrypt_id);
            $banner_data = DB::table(Config::get('constants.MANGAO_BANNER_MASTER').'  as MBM')->where('MBM.status', '<>', 3)->where('MBM.id', '=', $id)->select( 'MBM.id','MBM.banner_name','MBM.banner_position','MBM.banner_image')->get();
            
            // Make id encrypt
            $banner_data[0]->id = Crypt::encryptString($banner_data[0]->id);
            
            //make image url
            $url =Storage::url($banner_data[0]->banner_image);
            $banner_data[0]->show_banner_image = url($url);
            
            
            
            $class_name ='Cn_banner';
           
            if(!empty($banner_data[0])){
                return view('admin/categories-banner-section/banner_master',compact('class_name','banner_data'));
            }else{
               return redirect('banner')->with('error', 'something went wrong');
            }
        } catch (DecryptException $e) {
            return redirect('banner')->with('error', 'something went wrong');
        }

    }


}
