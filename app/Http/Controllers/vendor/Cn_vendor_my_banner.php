<?php

namespace App\Http\Controllers\vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\vendor\Md_mangao_vendor_banner;
use DataTables;
use Illuminate\Support\Facades\Crypt;


class Cn_vendor_my_banner extends Controller
{
    /**
     * Display a listing of the my banner.
     *
     * @return \Illuminate\Http\Response
     */
    public function fun_vendor_my_banner()
    {
        $class_name ="cn_vendor_my_banner";
        return view('vendor.master.vw_my_banner_list',compact('class_name'));
    }


    /**
     * This are used to add banner Action .
     *
     * @return \Illuminate\Http\Response
     */
    public function fun_vendor_my_banner_action(Request $request)
    {
       // $this->validate($request, [
       //     'banner_name' => 'required','banner_position' => 'required|numeric'
       //  ]);
        

        // function used for add single array 
        $Md_mangao_vendor_banner = new Md_mangao_vendor_banner;
        if(!empty($request->txtpkey)){
            $msg = "updated";
            $txtpkey =  Crypt::decryptString($request->txtpkey);
            $data = Md_mangao_vendor_banner::where('id', $txtpkey)->get();
            if($data->isEmpty()){
                return redirect()->route('main.banner')->with('message', 'something went wrong');
            }else{
                $Md_mangao_vendor_banner = Md_mangao_vendor_banner::find($txtpkey);
                $Md_mangao_vendor_banner->updated_at   = date('Y-m-d h:i:s');
                $Md_mangao_vendor_banner->updated_by   = session()->get('&&*id$##');
                $Md_mangao_vendor_banner->updated_ip_address   = $request->ip();
            }
        }else{
            $msg = "Added";
            $Md_mangao_vendor_banner->created_at   = date('Y-m-d h:i:s');
            $Md_mangao_vendor_banner->created_by   = session()->get('&&*id$##');
            $Md_mangao_vendor_banner->created_ip_address   = $request->ip();
        }      
        $filename = '';
        if($request->has('vendor_banner_img')){
            $filename = time().'_'.$request->file('vendor_banner_img')->getClientOriginalName();
            $filePath = $request->file('vendor_banner_img')->storeAs('public/vendor/vendor_banner_img',$filename);  
        }else{
            $filePath = $request->admin_image_old;
        }
        $Md_mangao_vendor_banner->vendor_id   = session()->get('&&*id$##');
        $Md_mangao_vendor_banner->category_id   = session()->get('$%vendor_category_type_id&%*');
        $Md_mangao_vendor_banner->category_type   = session()->get('$%vendor_category_type&%*');
        $Md_mangao_vendor_banner->vendor_banner_img   = $filePath;
        $Md_mangao_vendor_banner->save();

        // this statement are used for getting the last inserted id
       //  $Md_mangao_vendor_banner->id;   

        return redirect()->route('vendor.my.banner')->with('message', 'Banner '. $msg);
       
    }

    

    public function fun_vendor_my_banner_datatable(Request $request)
    {
        if ($request->ajax()) {
            $data = Md_mangao_vendor_banner::latest()->select('vendor_banner_img','id','created_at')->where('status', '<>', 3)->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $btn = '<a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" flash="Banner" table="' . Crypt::encryptString('mangao_banner_masters') . '" redirect-url="' . Crypt::encryptString('banner') . '" title="Delete" ><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data['created_at']));
                    return $date_with_format;
                })
                ->addColumn('vendor_banner_img', function($data){
                    // $url =Storage::url($data['vendor_banner_img']);
                    return $admin_img = "<img src=".$data['vendor_banner_img']." height='80px' width='80px' />";
                })
                ->rawColumns(['date'])
                ->rawColumns(['action','vendor_banner_img'])
                ->make(true);
        }

    }

}
