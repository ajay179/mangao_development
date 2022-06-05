<?php

namespace App\Http\Controllers\vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\vendor\Md_mangao_vendor_promotional_banner;
use DataTables;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use DB;
use Config;
use Validator;

class Cn_vendor_promotional_banner extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fun_view_promotional_banner()
    {
        $class_name = 'cn_vendor_promotional_banner';
        return view('vendor.promotional_banner.vw_promotional_banner',compact('class_name'));
    }

    public function fun_promotional_banner_action(Request $request)
    {
       $this->validate($request, [
            'promotion_date' => 'required','sloat_id' => 'required',
        ]);
        
       $formdata = $request->all();
        $filename = '';
        if($request->has('promotion_banner_image')){
            $filename = time().'_'.$request->file('promotion_banner_image')->getClientOriginalName();
            $filePath = $request->file('promotion_banner_image')->storeAs('public/vendor_promotion_banner_image',$filename);  
        }else{
            $filePath = $request->banner_image_old;
        }
        $from_time = "1:30:00";
         $to_time = "2:00:00";
        $formdata['from_time']   = $from_time;
        $formdata['to_time']   = $to_time;
        $formdata['promotion_date']   = date('Y-m-d',strtotime($formdata['promotion_date']));
        $formdata['promotion_banner_image']   = $filePath;
        $formdata['category_type_id']   = session()->get('$%vendor_category_type_id&%*');
        $formdata['category_type']   = session()->get('$%vendor_category_type&%*');
        $formdata['vendor_id']   = session()->get('&&*id$##');
        if(!empty($formdata['txtpkey'])){
            $msg = "updated";
            $txtpkey =  Crypt::decryptString($formdata['txtpkey']);
            $data = Md_mangao_vendor_promotional_banner::where('id', $txtpkey)->get();
            if($data->isEmpty()){
                return redirect()->route('vendor.promotional.banner')->with('message', 'something went wrong');
            }else{
                
                $formdata['updated_by']   = session()->get('&&*id$##');
                $formdata['updated_at']   = date('Y-m-d h:i:s');
                $formdata['updated_ip_address']   = $request->ip();
                $formdata = Arr::except($formdata,['_token','txtpkey','banner_image_old']);
                $Md_mangao_categories = Md_mangao_vendor_promotional_banner::where('id',$txtpkey)->update($formdata);
            }
        }else{
            $msg = "Added";
           
            $formdata['created_by']   = session()->get('&&*id$##');
            $formdata['created_ip_address']   = $request->ip();
            $Md_mangao_categories = Md_mangao_vendor_promotional_banner::create($formdata);
        }      

        return redirect()->route('vendor.promotional.banner')->with('message', 'Promotional Image '. $msg);
       
    }


    public function get_data_table_of_vendor_promotional_banner(Request $request)
    {
         if ($request->ajax()) {
            $data = Md_mangao_vendor_promotional_banner::latest()->select('promotion_date','from_time','to_time','promotion_banner_image','created_at','id')->where('status', '<>', 3)->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $btn = '<a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record-of-vendor" flash="Promotional banner" table="' . Crypt::encryptString('mangao_vendor_promotional_banner') . '" redirect-url="' . Crypt::encryptString('vendor-promotional-banner') . '" title="Delete" ><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data['created_at']));
                    return $date_with_format;
                })
                ->addColumn('promotion_date', function($data){
                    $date_with_format = date('d M Y',strtotime($data['promotion_date']));
                    return $date_with_format;
                })
                ->addColumn('promotion_banner_image', function($data){
                    $url =Storage::url($data['promotion_banner_image']);
                    return $promotion_banner_image = "<img src=".url($url)."  width='100%' />";
                })
                ->rawColumns(['action','promotion_banner_image','promotion_date','date'])
                ->make(true);
        }

    }
}
