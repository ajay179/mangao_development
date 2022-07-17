<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Md_city_master;
use App\Models\Md_city_admin;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use DB;
use Config;
use Auth;

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

        $check_duplicate_city_admin = Md_city_admin::where('admin_email', $request->admin_email);
        if(!empty($request->txtpkey)){
          $check_duplicate_city_admin =  $check_duplicate_city_admin->where('id','<>', Crypt::decryptString($request->txtpkey));
        }
        $check_duplicate_city_admin = $check_duplicate_city_admin->where('status','<>', 3)->get();
        if($check_duplicate_city_admin->isNotEmpty()){
            return redirect()->route('city.admin')->with('error', 'This city admin email already added.');
        }else{

            if(!empty($request->txtpkey)){
                $msg = "updated";
                $txtpkey =  Crypt::decryptString($request->txtpkey);
                $data = Md_city_admin::where('id', $txtpkey)->get();
                if($data->isEmpty()){
                    return redirect()->route('city.admin')->with('message', 'something went wrong');
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
                $filePath = $request->file('admin_image')->storeAs('public/admin_image',$filename);  
            }else{
                $filePath = $request->admin_image_old;
            }
            $Md_city_admin->city_id   = $request->city_id;
            $Md_city_admin->admin_name   = $request->admin_name;
            $Md_city_admin->address   = $request->address;
            $Md_city_admin->commision   = $request->commision;
            $Md_city_admin->admin_email   = $request->admin_email;
            $Md_city_admin->admin_mobile   = $request->admin_mobile;
            $Md_city_admin->admin_img   =  $filePath;
            $Md_city_admin->password   = Hash::make($request->password);
            $Md_city_admin->encrypt_password   = Crypt::encryptString($request->password);
            $Md_city_admin->save();

            // this statement are used for getting the last inserted id
           //  $Md_city_master->id;   

            return redirect()->route('city.admin')->with('message', 'City admin'. $msg);
        }
    }


     public function get_data_table_of_city_admin(Request $request)
    {
        if ($request->ajax()) {
            $data = Md_city_admin::latest()->select('admin_name','address','commision','admin_email','admin_mobile','admin_img','id','created_at')->where('status', '<>', 3)->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $btn = '<a href="'. url("/cityadmin-secret-login") ."/". Crypt::encryptString($data->id).'" class="edit btn btn-primary btn-xs"><i class="fa fa-arrow-right"></i> login</a> <a href="'. url("/edit-cityadmin") ."/". Crypt::encryptString($data->id).'" class="edit btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>  <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" flash="City admin" table="' . Crypt::encryptString('mangao_city_admins') . '" redirect-url="' . Crypt::encryptString('admin-dashboard') . '" title="Delete" ><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data['created_at']));
                    return $date_with_format;
                })
                ->addColumn('admin_image', function($data){
                    $url =Storage::url($data['admin_img']);
                    return $admin_img = "<img src=".url($url)." height='100px' width='180px' />";
                })
                ->rawColumns(['date'])
                ->rawColumns(['action','admin_image'])
                ->make(true);
        }

    }


    public function fun_edit_city_admin($encrypt_id)
    {
        try {
            
            $id =  Crypt::decryptString($encrypt_id);
            $cityadmin_data = DB::table(Config::get('constants.MANGAO_CITY_ADMIN').'  as MCA')->where('MCA.status', '<>', 3)->where('MCA.id', '=', $id)->select('MCA.city_id', 'MCA.id','MCA.admin_name','MCA.address','MCA.commision','MCA.admin_email','MCA.admin_mobile','MCA.admin_img','MCA.encrypt_password')->get();
            $city_data = Md_city_master::latest()->where('status','<>',3)->select('city_name','id','created_at')->get();
            
            // Make id encrypt
            $cityadmin_data[0]->id = Crypt::encryptString($cityadmin_data[0]->id);
            
            //make image url
            $url =Storage::url($cityadmin_data[0]->admin_img);
            $cityadmin_data[0]->show_admin_img = url($url);
            
            //decrypt password
            $cityadmin_data[0]->encrypt_password = Crypt::decryptString($cityadmin_data[0]->encrypt_password);
            
            $class_name ='cn_master_cityadmin';
           
            if(!empty($cityadmin_data[0])){
                return view('admin/city-cityadmin/add_city_admin_master',compact('class_name','cityadmin_data','city_data'));
            }else{
               return redirect('city-admin')->with('error', 'something went wrong');
            }
        } catch (DecryptException $e) {
            return redirect('city-admin')->with('error', 'something went wrong');
        }

    }



    public function fun_city_admin_secret_login($encrypt_id)
    {
        try {
            
            $id =  Crypt::decryptString($encrypt_id);
            $cityadmin_data = DB::table(Config::get('constants.MANGAO_CITY_ADMIN').'  as MCA')->where('MCA.status', '<>', 3)->where('MCA.id', '=', $id)->select('MCA.city_id', 'MCA.id','MCA.admin_name','MCA.admin_email','MCA.encrypt_password')->get();
            
            if(!empty($cityadmin_data[0])){
                $admin_data = array(
                    'admin_email' =>$cityadmin_data[0]->admin_email,
                    'password' =>  Crypt::decryptString($cityadmin_data[0]->encrypt_password)
                );  
                if(Auth::guard('city_admin')->attempt($admin_data)){
                    // Session::flush();
                    
                    Session::put('&%*$$cityadminusername$%#', Auth::guard('city_admin')->user()->admin_name);
                    Session::put('&%*id$%#', Auth::guard('city_admin')->user()->id);
                    Session::put('$%#city_admin_email&%*', Auth::guard('city_admin')->user()->admin_email);
                    Session::put('$%#city_id&%*', Auth::guard('city_admin')->user()->city_id);

                    if (Session::has('&%*$$cityadminusername$%#', '&%*id$%#', '$%#city_admin_email&%*')) {
                        return redirect('city-admin-dashbord')->with('message', 'Successfully Logged In!');
                    } else {
                        return redirect('city-admin')->with('error', 'You have entered wrong credentials.. Please try again...');
                    }
                
                }else{
                    return redirect('city-admin')->with('error', 'You have entered wrong password.. Please try again...');
                }
            }else{
               return redirect('city-admin')->with('error', 'something went wrong');
            }
        } catch (DecryptException $e) {
            return redirect('city-admin')->with('error', 'something went wrong');
        }

    }

    
}
