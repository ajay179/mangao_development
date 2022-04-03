<?php

namespace App\Http\Controllers\api\login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\api\Cn_base_controller as Cn_base_controller;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class Cn_login extends Cn_base_controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fun_user_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_no' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(),'401');       
        }
        
        $user= User::where('mobile_no', $request->mobile_no)->first();
        // print_r($data);
            if ($user->isEmpty()) {
                $otp = rand(1000,9999);
                 user::create([
                    'mobile_no' => $request->mobile_no,
                    'otp' => $otp,
                    'created_ip_address' => $request->ip(),
                    ]);
            }
    
             $token = $user->createToken('my-app-token')->plainTextToken;
        
            $response = [
                'user' => Crypt::encryptString($user),
                'token' => $token,
                'mobile_no' => $request->mobile_no,
                'otp' => $otp
            ];
        
             // return response($response, 201);
             return $this->sendResponse($response, 'User login successfully.');
         
    }
}
