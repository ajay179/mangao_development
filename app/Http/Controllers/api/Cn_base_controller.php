<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;

class Cn_base_controller extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data'  => $result,
        ];
        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    // public function verifiedAppToken(Request $request)
    // {   
    //     $access_token = $request->header('Access-Token');
    //     if(!empty($access_token)){
    //         $user_data = Crypt::decryptString($access_token);
    //         $user_data = json_decode($user_data, true);
    //         $user= User::where('id','=', $user_data['id'])->where('otp_verified_status','=', 'verified')->where('status','=', 1)->first();
    //         if(!empty($user)){
    //             return $user_data['id'];
    //         }else{
    //             return false;
    //         }
    //     }else{
    //         return false;
            
    //     }
    // }
}
