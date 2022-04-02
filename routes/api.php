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

// All Authentication URL's are in this middleware
Route::group(['middleware' => 'auth:sanctum'], function(){
    //All secure URL's
    Route::get('with-auth', function (Request $request) {
        return "api success";
    })->name('show-data-use-auth');
});
