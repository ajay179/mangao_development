<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\Md_city_master;
use Illuminate\Support\Facades\Crypt;
use DataTables;
use Config;
use DB;
class Cn_master_city extends Controller
{
    /**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function index()
    {
        $class_name ='Cn_master_city';
        return view('admin/city-cityadmin/city_master',compact('class_name'));
    }

    /**
     * This are used to add city .
     *
     * @return \Illuminate\Http\Response
     */
    public function cityAction(Request $request)
    {
       $this->validate($request, [
            'city_name' => 'required'
        ]);
        
        // function used for add single array 
        $Md_city_master = new Md_city_master;
        if(!empty($request->txtpkey)){
            $msg = "updated";
            $txtpkey =  Crypt::decryptString($request->txtpkey);
            $data = Md_city_master::where('id', $txtpkey)->get();
            if($data->isEmpty()){
                return redirect()->route('city')->with('message', 'something went wrong');
            }else{
                $Md_city_master = Md_city_master::find($txtpkey);
                $Md_city_master->updated_at   = date('Y-m-d h:i:s');
                $Md_city_master->updated_by   = session()->get('*$%&%*id**$%#');
                $Md_city_master->updated_ip_address   = $request->ip();
            }
        }else{
            $msg = "Added";
            $Md_city_master->created_at   = date('Y-m-d h:i:s');
            $Md_city_master->created_by   = session()->get('*$%&%*id**$%#');
            $Md_city_master->created_ip_address   = $request->ip();
        }           
        $Md_city_master->city_name   = $request->city_name;
        $Md_city_master->save();

        // this statement are used for getting the last inserted id
       //  $Md_city_master->id;   

        return redirect()->route('city')->with('message', 'City '. $msg);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_data_table_of_city(Request $request)
    {
        if ($request->ajax()) {
            
            $data = Md_city_master::where('status', '<>', 3)->select('city_name', 'id', 'created_at','status')->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                    $btn = '<a href="'. url("/edit-city") ."/". Crypt::encryptString($data->id).'" class="edit btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>  <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" flash="City" table="' . Crypt::encryptString('mangao_city_masters') . '" redirect-url="' . Crypt::encryptString('admin-dashboard') . '" title="Delete" ><i class="fa fa-trash"></i></a> ';
                    return $btn;
                })
                
                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data->created_at));
                    return $date_with_format;
                })

                
                ->rawColumns(['date'])
                ->rawColumns(['action-js']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }

    }


    public function check_duplicate_city(Request $request)
    {
        if ($request->ajax()) {
            try {
                $id = $request->txtpkey;
                if (!empty($id)) {
                    $id =   Crypt::decryptString($request->txtpkey);
                    $city_data = Md_city_master::where('id','<>', $id)->where('city_name', $request->city_name)->where('status', '<>', 3)->get();
                } else {
                    $city_data = Md_city_master::where('city_name', $request->city_name)->where('status', '<>', 3)->get();
                }
                
                if (!empty($city_data[0])) {
                    echo "false";
                } else {
                    echo "true";
                }
            } catch (DecryptException $e) {
                return redirect('city')->with('error', 'something went wrong');
            }
        }else{
            exit('No direct script access allowed');
        }

    }

    public function fun_edit_city($encrypt_id)
    {
        try {
            
            $id =  Crypt::decryptString($encrypt_id);
            $city_data = DB::table(Config::get('constants.MANGAO_CITY_MASTER').'  as MCM')->where('MCM.status', '<>', 3)->where('MCM.id', '=', $id)->select('MCM.city_name', 'MCM.id')->get();

            $city_data[0]->id = Crypt::encryptString($city_data[0]->id);
            $class_name ='Cn_master_city';
           
            if(!empty($city_data[0])){
                return view('admin/city-cityadmin/city_master',compact('class_name','city_data'));
            }else{
               return redirect('city')->with('error', 'something went wrong');
            }
        } catch (DecryptException $e) {
            return redirect('city')->with('error', 'something went wrong');
        }

    }

}
