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

Route::group(['middleware'=>['isVendor']], function(){

		//Vendor dashboard route
		Route::get('vendor-dashbord', [App\Http\Controllers\vendor\Cn_vendor_dashboard::class,'index']);


		//Vendor Category 
		Route::get('vendor-category', [App\Http\Controllers\vendor\Cn_category_master::class,'index'])->name('vendor.category');
		Route::post('vendor-category-action', [App\Http\Controllers\vendor\Cn_category_master::class,'vendorCategoryAction'])->name('vendor.category.action');

		//Vendor Sub Category 
		Route::get('vendor-sub-category', [App\Http\Controllers\vendor\Cn_sub_category_master::class,'index'])->name('vendor.sub.category');
		Route::post('vendor-sub-category-action', [App\Http\Controllers\vendor\Cn_category_master::class,'index'])->name('vendor.sub.category.action');
});
	


