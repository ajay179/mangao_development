<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class Cn_vendor_common_controller extends Controller
{
    /**
     * Delete dynamic controller resource.
     * This function are used to delete the data from table.
     * This is common function of every delete button.This is soft delete function.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete_common_function_vendor(Request $request)
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
                return redirect('city-admin-dashbord')->with('error', 'something went wrong');
            }
        }else{
            exit('No direct script access allowed');
        }

    }
}
