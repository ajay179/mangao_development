<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/vendor-login', function () {
    return view('vendor/login/login');
})->middleware('isvendoradminloginAuth');

Route::get('/vendor-admin-logout', function(){
		if (session()->has('&%*$$vendoradminusername$%#','&%*id$%#')) {
			Session::flush();
		}
		return redirect('/vendor');
	});
	
Route::post('check-login-for-vendor',[App\Http\Controllers\vendor\Cn_login::class,'vendor_login']);

Route::group(['middleware'=>['isVendorAdmin']], function(){

	
});
	


