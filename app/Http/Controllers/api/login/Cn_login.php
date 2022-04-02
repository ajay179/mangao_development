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
            'email' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(),'401');       
        }
        
        $user= User::where('email', $request->email)->first();
        // print_r($data);
            if (!$user) {

                return $this->sendError('Unauthorised.', ['error'=>'These credentials do not match our records.']);
            }
    
             $token = $user->createToken('my-app-token')->plainTextToken;
        
            $response = [
                'user' => Crypt::encryptString($user),
                'token' => $token
            ];
        
             // return response($response, 201);
             return $this->sendResponse($response, 'User login successfully.');
    }
}
