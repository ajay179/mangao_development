<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\Md_wallet_normal_plan;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Illuminate\Support\Facades\Crypt;
use DB;
use Config;

class Cn_wallet_offers extends Controller
{
    /**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function index()
    {
        $class_name ='cn_wallet_offers';
        return view('admin/wallet-offer-plan/wallet_normal_plan',compact('class_name'));
    }

    /**
     * This are used to add city .
     *
     * @return \Illuminate\Http\Response
     */
    public function normalPlanAction(Request $request)
    {
       $this->validate($request, [
            'wallet_amount' => 'required'
        ]);
        
        // function used for add single array 
        $Md_wallet_normal_plan = new Md_wallet_normal_plan;
        $check_duplicate_plan = Md_wallet_normal_plan::where('wallet_amount', $request->wallet_amount);
        if(!empty($request->txtpkey)){
          $check_duplicate_plan =  $check_duplicate_plan->where('id','<>', Crypt::decryptString($request->txtpkey));
        }
        $check_duplicate_plan = $check_duplicate_plan->where('status','<>', 3)->get();
        
        if($check_duplicate_plan->isNotEmpty()){
            return redirect()->route('wallet.normal.plan')->with('error', 'This plan already added.');
        }else{
            if(!empty($request->txtpkey)){
                $msg = "updated";
                $txtpkey =  Crypt::decryptString($request->txtpkey);
                $data = Md_wallet_normal_plan::where('id', $txtpkey)->get();
                if($data->isEmpty()){
                    return redirect()->route('wallet.normal.plan')->with('error', 'something went wrong');
                }else{
                    $Md_wallet_normal_plan = Md_wallet_normal_plan::find($txtpkey);
                    $Md_wallet_normal_plan->updated_at   = date('Y-m-d h:i:s');
                    $Md_wallet_normal_plan->updated_by   = session()->get('*$%&%*id**$%#');
                    $Md_wallet_normal_plan->updated_ip_address   = $request->ip();
                }
            }else{
                $msg = "Added";
                $Md_wallet_normal_plan->created_at   = date('Y-m-d h:i:s');
                $Md_wallet_normal_plan->created_by   = session()->get('*$%&%*id**$%#');
                $Md_wallet_normal_plan->created_ip_address   = $request->ip();
            }           
            $Md_wallet_normal_plan->wallet_amount   = $request->wallet_amount;
            $Md_wallet_normal_plan->save();

            // this statement are used for getting the last inserted id
           //  $Md_city_master->id;   

            return redirect()->route('wallet.normal.plan')->with('message', 'Plan Amount '. $msg);
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_data_table_of_normal_plan(Request $request)
    {
        if ($request->ajax()) {
            
            $data = Md_wallet_normal_plan::where('status', '<>', 3)->select('wallet_amount', 'id', 'created_at','status')->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                    $btn = '<a href="'. url("/edit-normal-plan") ."/". Crypt::encryptString($data->id).'" class="edit btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>  <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" flash="Plan Amount" table="' . Crypt::encryptString('mangao_wallet_noraml_plan') . '" redirect-url="' . Crypt::encryptString('wallet.normal.plan') . '" title="Delete" ><i class="fa fa-trash"></i></a> ';
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


    public function check_duplicate_plan_amount(Request $request)
    {
        if ($request->ajax()) {
            try {
                $id = $request->txtpkey;
                if (!empty($id)) {
                    $id =   Crypt::decryptString($request->txtpkey);
                    $wallet_data = Md_wallet_normal_plan::where('id','<>', $id)->where('wallet_amount', $request->wallet_amount)->where('status', '<>', 3)->get();
                } else {
                    $wallet_data = Md_wallet_normal_plan::where('wallet_amount', $request->wallet_amount)->where('status', '<>', 3)->get();
                }
                
                if (!empty($wallet_data[0])) {
                    echo "false";
                } else {
                    echo "true";
                }
            } catch (DecryptException $e) {
                return redirect('wallet.normal.plan')->with('error', 'something went wrong');
            }
        }else{
            exit('No direct script access allowed');
        }

    }

    public function fun_edit_wallet_normal_plan($encrypt_id)
    {
        try {
            
            $id =  Crypt::decryptString($encrypt_id);
            $wallet_data = DB::table(Config::get('constants.MANGAO_WALLET_NORMAL_PLAN').'  as MWNP')->where('MWNP.status', '<>', 3)->where('MWNP.id', '=', $id)->select('MWNP.wallet_amount', 'MWNP.id')->get();

            $wallet_data[0]->id = Crypt::encryptString($wallet_data[0]->id);
            $class_name ='cn_wallet_offers';
           
            if(!empty($wallet_data[0])){
                return view('admin/wallet-offer-plan/wallet_normal_plan',compact('class_name','wallet_data'));
            }else{
               return redirect('wallet.normal.plan')->with('error', 'something went wrong');
            }
        } catch (DecryptException $e) {
            return redirect('wallet.normal.plan')->with('error', 'something went wrong');
        }

    }
}