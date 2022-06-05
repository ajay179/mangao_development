<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('user-auth', function (Request $request) {
    $response = [
            'success' => false,
            'message' => "User not authenticate",
        ];
        return response()->json($response, '403');
})->name('user-auth');


Route::post('user-login', [App\Http\Controllers\api\login\Cn_login::class,'fun_user_login']);
Route::post('verify-user-otp', [App\Http\Controllers\api\login\Cn_login::class,'fun_user_otp_verification']);
Route::post('resend-user-otp', [App\Http\Controllers\api\login\Cn_login::class,'fun_user_resend_otp']);


// All Authentication URL's are in this middleware
Route::group(['middleware' => 'auth:sanctum'], function(){
    //All secure URL's
    Route::post('user-registration', [App\Http\Controllers\api\login\Cn_login::class,'fun_user_registration']);
    //Home Api
Route::post('home', [App\Http\Controllers\api\home_controller\Cn_home_controller::class,'fun_home_page']);
Route::post('get-vendor-listing-by-category-id', [App\Http\Controllers\api\home_controller\Cn_home_controller::class,'fun_get_vendor_listing']);
});
