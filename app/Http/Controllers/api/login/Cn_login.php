<?php

namespace App\Http\Controllers\api\login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\api\Cn_base_controller as Cn_base_controller;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Config;

class Cn_login extends Cn_base_controller
{
     /**
     * This function are used to store user mobile no and send otp to this mobile no.
     *
     * @return \Illuminate\Http\Response
     */
    public function fun_user_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_no' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|digits:10|numeric',
            'ip_address' => 'required|ip',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(),'401');       
        } 
        $user= User::where('mobile_no', $request->mobile_no)->where('status','=', 1)->first();
        // $otp = rand(1000,9999);
        $otp = "1234";
        if (!empty($user)) {  
            $user = User::where('mobile_no',$request->mobile_no)->update([
                'otp' => $otp,
                'password'=>Hash::make('admin@123'),
                'created_ip_address' => $request->ip_address,
                ]);
            $res = $user;
        }else{
            $user = User::create([
                'mobile_no' => $request->mobile_no,
                'otp' => $otp,
                'password'=>Hash::make('admin@123'),
                'created_ip_address' => $request->ip_address,
                ]);
            $res = $user->id;
        }
        
        if(!empty($res)){
            $response = [
                'mobile_no' => $request->mobile_no,
            ];
            return $this->sendResponse($response, 'User mobile no. registration successful.');
        }else{   
           return $this->sendError('User Registration faild', "",'500');     
        }
    }

    /**
     * This function are used to user OTP verification.
     *
     * @return \Illuminate\Http\Response
     */
    public function fun_user_otp_verification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_no' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|digits:10|numeric',
            'ip_address' => 'required|ip',
            'otp' => 'required|numeric|digits:4',
        ]);

        
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(),'401');       
        } 

        $user_form_data=array(
            'mobile_no'=> $request->mobile_no,
            'otp'=> $request->otp,
            'password'=>'admin@123',
            'status'=> 1
        );
        // $user= User::where('mobile_no','=', $request->mobile_no)->where('otp','=', $request->otp)->where('status','=', 1)->select('first_name','id','last_name','email','mobile_no','otp_verified_status')->first();
        // if (!empty($user)) { 
        if (Auth::attempt($user_form_data)) {
            $user = Auth::user();
            $user_details = User::where('id', $user->id)->where('status','=', 1)->select('first_name','last_name','mobile_no','email','user_type','otp_verified_status')->first();
            $token = $user->createToken('my-app-token')->plainTextToken;

            User::where('mobile_no',$request->mobile_no)->update([
                'otp_verified_status' => 'verified',
                'remember_token' =>  $token,
                'created_ip_address' => $request->ip_address,
                ]);
            $response = [
                'token' => $token,
                 // 'user_id' => Crypt::encryptString($user),
                'user_data' => $user_details,
            ];
            return $this->sendResponse($response, 'User OTP verification successfully.');
        }else{
           return $this->sendError('Please enter valid OTP.', "",'403');
        }
    }


    /**
     * This function are used to resend OTP.
     *
     * @return \Illuminate\Http\Response
     */
    public function fun_user_resend_otp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_no' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|digits:10|numeric',
            'ip_address' => 'required|ip',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(),'401');       
        } 
        $user= User::where('mobile_no','=', $request->mobile_no)->where('status','=', 1)->first();
        if (!empty($user)) {  
            $otp = "1234";
            User::where('mobile_no',$request->mobile_no)->update([
                'otp_verified_status' => 'unverified',
                'remember_token' =>  NULL,
                'otp' => $otp,
                'created_ip_address' => $request->ip_address,
                ]);
            $response = [
                'mobile_no' => $request->mobile_no,
            ];
            return $this->sendResponse($response, 'OTP resend successfully.');
        }else{
           return $this->sendError('Mobile no not registered.', "",'403');
        }
    }


    /**
     * This function are used to for user registration.
     *
     * @return \Illuminate\Http\Response
     */
    public function fun_user_registration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|alpha_num',
            'last_name' => 'required|alpha_num',
            'email' => 'required|email',
            'ip_address' => 'required|ip',
        ]);
    
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(),'401');       
        } 
        $user_id = Auth::user()->id;
        $user = User::where('id',$user_id)->update([
                'first_name' => $request->first_name,
                'last_name' =>  $request->last_name,
                'email' => $request->email,
                'updated_by' => $user_id,
                'created_by' => $user_id,
                'updated_ip_address' => $request->ip_address,
            ]);
        $user_data = User::where('id',$user_id)->get();
        if (!empty($user)) {  
            return $this->sendResponse($user_data,'User registration successfull.');
        }else{
            return $this->sendError('User not registered', "",'500');
        }
       
    }



}
