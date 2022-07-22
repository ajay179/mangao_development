<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class Cn_common_controller extends Controller
{
	/**
	 * Delete dynamic controller resource.
	 * This function are used to delete the data from table.
	 * This is common function of every delete button.This is soft delete function.
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function delete_common_function(Request $request)
    {
        if ($request->ajax()) {
            try {
                $id =   Crypt::decryptString($request->id);
                $table =   Crypt::decryptString($request->table);
               
                $data = DB::table($table)->where('id', $id)
                    ->where('status', '<>', 3)
                    ->get();

                if($data->isEmpty()){
                    $message = [
                        'message' =>  $request->flashdata_message.' Not Found.',
                        'status' => false,
                    ];
                    return response()->json($message);
                }else{
                    $update_bool = DB::table($table)->where('id', $id)->update(['status' => 3]);
                    $message = [
                        'message' =>  $request->flashdata_message." deleted successfully.",
                        'status' => true,
                    ];
                    return response()->json($message);
                  
                }
            } catch (DecryptException $e) {
                return redirect('admin-dashbord')->with('error', 'something went wrong');
            }
        }else{
            exit('No direct script access allowed');
        }

    }


    public function fun_superadmin_change_user_status(Request $request)
    {
        if ($request->ajax()) {
            try {

                $id =   Crypt::decryptString($request->id);
                $table =   Crypt::decryptString($request->table);
                $status =   Crypt::decryptString($request->status);
                
                if($status == 3){
                    $update_status = 3; 
                    $status_msg = "delete";
                }else{
                    $update_status = ($status == 1) ? 2 : 1; 
                    $status_msg = "status updated";
                }
                $data = DB::table($table)->where('id', $id)
                    ->where('status', '<>', 3)
                    ->get();

                if($data->isEmpty()){
                    $message = [
                        'message' =>  $request->flashdata_message.' Not Found.',
                        'status' => false,
                    ];
                    return response()->json($message);
                }else{
                    $update_bool = DB::table($table)->where('id', $id)->update(['status' => $update_status]);
                    $message = [
                        'message' =>  $request->flashdata_message.' '.$status_msg. "  successfully.",
                        'status' => true,
                    ];
                    return response()->json($message);
                  
                }
            } catch (DecryptException $e) {
                $message = [
                        'message' =>  'Something went wrong.',
                        'status' => false,
                    ];
                return response()->json($message);
            }
        }else{
            exit('No direct script access allowed');
        }
    }
}
