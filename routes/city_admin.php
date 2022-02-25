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

Route::get('/city-admin-login', function () {
    return view('city_admin/login/login');
})->middleware('iscityadminloginAuth');

Route::get('/city-admin-logout', function(){
		if (session()->has('&%*$$cityadminusername$%#','&%*id$%#')) {
			Session::flush();
		}
		return redirect('/city-admin');
	});
	
Route::post('check-login-for-city-admin',[App\Http\Controllers\city_admin\Cn_login::class,'city_admin_login']);

Route::group(['middleware'=>['isCityAdmin']], function(){

	//city admin dashboard route
	Route::get('city-admin-dashbord', [App\Http\Controllers\city_admin\Cn_city_admin_dashboard::class,'index']);


	// User Management Vendor Routing
	Route::get('cityadmin/view-vendor', [App\Http\Controllers\city_admin\Cn_user_management::class,'fun_vendor_list'])->name('cityadmin.view.vendor.list');
	
	Route::get('cityadmin/add-vendor', [App\Http\Controllers\city_admin\Cn_user_management::class,'fun_add_vendor'])->name('cityadmin.add.vendor');


	Route::get('cityadmin/view-delivery-boy', [App\Http\Controllers\city_admin\Cn_user_management::class,'fun_delivery_boy_list'])->name('cityadmin.view.delivery.boy.list');
	Route::get('cityadmin/add-delivery-boy', [App\Http\Controllers\city_admin\Cn_user_management::class,'fun_add_delivery_boy'])->name('cityadmin.add.delivery.boy');





});
	


