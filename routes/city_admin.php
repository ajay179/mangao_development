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
		return redirect('/city-admin-login');
	})->can('isCityAdmin');
	
Route::post('check-login-for-city-admin',[App\Http\Controllers\city_admin\Cn_login::class,'city_admin_login']);

Route::group(['middleware'=>['isCityAdmin','can:isCityAdmin']], function(){

	//city admin dashboard route
	Route::get('city-admin-dashbord', [App\Http\Controllers\city_admin\Cn_city_admin_dashboard::class,'index']);

	// city admin Soft delete common function
	Route::post('soft-delete-of-city-admin', [App\Http\Controllers\Cn_city_common_controller::class, 'delete_common_function_city_admin']);

	// User Management Vendor Routing
	Route::get('cityadmin/view-vendor', [App\Http\Controllers\city_admin\Cn_user_management::class,'fun_vendor_list'])->name('cityadmin.view.vendor.list');
	
	Route::get('cityadmin/add-vendor', [App\Http\Controllers\city_admin\Cn_user_management::class,'fun_add_vendor'])->name('cityadmin.add.vendor');
	Route::post('cityadmin/vendor-cityadmin-action', [App\Http\Controllers\city_admin\Cn_user_management::class,'vendorCityAdminAction'])->name('cityadmin.vendor.action');
	Route::get('cityadmin/cityadmin-vendor-datatable', [App\Http\Controllers\city_admin\Cn_user_management::class, 'get_data_table_of_city_admin_vendor'])->name('cityadminvendor.getDataTable');
	Route::get('cityadmin/edit-cityadmin-vendor/{id}', [App\Http\Controllers\city_admin\Cn_user_management::class, 'fun_edit_city_admin_vendor']);


	Route::get('cityadmin/view-delivery-boy', [App\Http\Controllers\city_admin\Cn_user_management::class,'fun_delivery_boy_list'])->name('cityadmin.view.delivery.boy.list');
	Route::get('cityadmin/add-delivery-boy', [App\Http\Controllers\city_admin\Cn_user_management::class,'fun_add_delivery_boy'])->name('cityadmin.add.delivery.boy');


// Withdrwal Request routes

	Route::get('cityadmin/vendor-withdrwal', [App\Http\Controllers\city_admin\Cn_city_admin_withdrwal_request::class,'fun_vendor_withdrwal_page'])->name('cityadmin.vendor.withdrwal');
	Route::get('cityadmin/delivery-boy-withdrwal', [App\Http\Controllers\city_admin\Cn_city_admin_withdrwal_request::class,'fun_delivery_boy_withdrwal_page'])->name('cityadmin.delivery.boy.withdrwal');

	// Account Settlement routes
	
	Route::get('cityadmin/vendor-account-settlement', [App\Http\Controllers\city_admin\Cn_city_admin_account_settlement::class,'vendor_account_settlement_page'])->name('cityadmin.vendor.account.settlement');
	Route::get('cityadmin/delivery-boy-account-settlement', [App\Http\Controllers\city_admin\Cn_city_admin_account_settlement::class,'delivery_boy_account_settlement_page'])->name('cityadmin.delivery.boy.account.settlement');

	// Order routes
	Route::get('cityadmin/ongoing-orders', [App\Http\Controllers\city_admin\Cn_city_admin_orders::class,'index'])->name('cityadmin.ongoing.orders');
	// Route::get('cityadmin/completed-orders', [App\Http\Controllers\city_admin\Cn_city_admin_orders::class,'fun_completed_orders'])->name('cityadmin.completed.orders');
	// Route::get('cityadmin/cancelled-orders', [App\Http\Controllers\city_admin\Cn_city_admin_orders::class,'fun_cancelled_orders'])->name('cityadmin.cancelled.orders');
	// Route::get('cityadmin/returned-orders', [App\Http\Controllers\city_admin\Cn_city_admin_orders::class,'fun_returned_orders'])->name('cityadmin.returned.orders');


});
	


