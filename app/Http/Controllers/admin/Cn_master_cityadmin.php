<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\Md_city_master;
use App\models\Md_city_admin;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Illuminate\Support\Facades\Crypt;

class Cn_master_cityadmin extends Controller
{
    /**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function index()
    {
        $class_name ='Cn_master_cityadmin';
        return view('admin/city-cityadmin/city_admin_master',compact('class_name'));
    }

    /**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function add_cityadmin()
    {
        $class_name ='Cn_master_cityadmin';
        $city_data = Md_city_master::latest()->where('status','<>',3)->select('city_name','id','created_at')->get();
        return view('admin/city-cityadmin/add_city_admin_master',compact('class_name','city_data'));
    }

    /**
     * This are used to add city .
     *
     * @return \Illuminate\Http\Response
     */
    public function cityAdminAction(Request $request)
    {
       $this->validate($request, [
            'city_id' => 'required','admin_name' => 'required','address' => 'required','commision' => 'required','admin_email' => 'required','admin_mobile' => 'required','password' => 'required'
        ]);
        
        // function used for add single array 
        $Md_city_admin = new Md_city_admin;
        if(!empty($request->txtpkey)){
            $msg = "updated";
            $txtpkey =  Crypt::decryptString($request->txtpkey);
            $data = Md_city_admin::where('id', $txtpkey)->get();
            if($data->isEmpty()){
                return redirect()->route('city-admin')->with('message', 'something went wrong');
            }else{
                $Md_city_admin = Md_city_admin::find($txtpkey);
                $Md_city_admin->updated_at   = date('Y-m-d h:i:s');
                $Md_city_admin->updated_by   = session()->get('*$%&%*id**$%#');
                $Md_city_admin->updated_ip_address   = $request->ip();
            }
        }else{
            $msg = "Added";
            $Md_city_admin->created_at   = date('Y-m-d h:i:s');
            $Md_city_admin->created_by   = session()->get('*$%&%*id**$%#');
            $Md_city_admin->created_ip_address   = $request->ip();
        }      
        $filename = '';
        if($request->has('admin_image')){
            $filename = time().'_'.$request->file('admin_image')->getClientOriginalName();
            $filePath = $request->file('admin_image')->storeAs('public\admin_image',$filename);  
        }   
        $Md_city_admin->city_id   = $request->city_id;
        $Md_city_admin->admin_name   = $request->admin_name;
        $Md_city_admin->address   = $request->address;
        $Md_city_admin->commision   = $request->commision;
        $Md_city_admin->admin_email   = $request->admin_email;
        $Md_city_admin->admin_mobile   = $request->admin_mobile;
        $Md_city_admin->admin_img   =  $filename;
        $Md_city_admin->password   = Hash::make($request->password);
        $Md_city_admin->save();

        // this statement are used for getting the last inserted id
       //  $Md_city_master->id;   

        return redirect()->route('city.admin')->with('message', 'City admin'. $msg);
    }


     public function get_data_table_of_city_admin(Request $request)
    {
        if ($request->ajax()) {
            $data = Md_city_admin::latest()->select('admin_name','address','commision','admin_email','admin_mobile','admin_img','id','created_at')->where('status', '<>', 3)->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $btn = '<a href="'. url("/edit-city") ."/". Crypt::encryptString($data->id).'" class="edit btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>  <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" flash="City" table="' . Crypt::encryptString('mangao_city_masters') . '" redirect-url="' . Crypt::encryptString('admin-dashboard') . '" title="Delete" ><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data['created_at']));
                    return $date_with_format;
                })
                ->addColumn('admin_img', function($data){
                    // $url= asset('storage/'.$data['banner_img']);
                    // storage_path('app/public'),
                     // return $url =Storage::disk('public')->get($data['banner_img']);
                      $url =Storage::url($data['admin_img']);
                    return $admin_img = "<img src=".url($url)." height='100px' width='180px' />";
                    
                })
                ->rawColumns(['date'])
                ->rawColumns(['action'])
                ->rawColumns(['admin_img'])
                ->make(true);
        }

    }

    
}
