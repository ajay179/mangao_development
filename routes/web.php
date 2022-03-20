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

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();


Route::get('/admin', function () {
    return view('admin/login/login');
})->middleware('isadminloginAuth');

Route::get('/admin-logout', function(){
		if (session()->has('**^&%*$$username**$%#','*$%&%*id**$%#')) {
			// session()->pull('username', null);
			// session()->pull('id', null);
			// session()->pull('email', null);
			Session::flush();
		}
		return redirect('/admin');
	})->can('isSuperAdmin');
	
Route::post('check-login-for-admin',[App\Http\Controllers\admin\Cn_login::class,'admin_login']);
	

Route::group(['middleware'=>['isAdmin','can:isSuperAdmin']], function(){

	//dashboard route
	Route::get('admin-dashbord', [App\Http\Controllers\admin\Cn_dashboard::class,'index']);
	
	// Soft delete common funtion
	Route::post('soft-delete', [App\Http\Controllers\Cn_common_controller::class, 'delete_common_function']);

	// City Routes
	Route::get('city', [App\Http\Controllers\admin\Cn_master_city::class,'index'])->name('city');
	Route::post('city-action', [App\Http\Controllers\admin\Cn_master_city::class,'cityAction'])->name('city.action');
Route::get('city-datatable', [App\Http\Controllers\admin\Cn_master_city::class, 'get_data_table_of_city'])->name('city.getDataTable');
	Route::post('check-duplicate-city', [App\Http\Controllers\admin\Cn_master_city::class,'check_duplicate_city']);
	Route::get('edit-city/{id}', [App\Http\Controllers\admin\Cn_master_city::class, 'fun_edit_city']);


	// City admin Routes
	Route::get('city-admin', [App\Http\Controllers\admin\Cn_master_cityadmin::class,'index'])->name('city.admin');
	Route::get('admin/add-cityadmin', [App\Http\Controllers\admin\Cn_master_cityadmin::class,'add_cityadmin'])->name('city.add.admin');
	Route::post('cityadmin-action', [App\Http\Controllers\admin\Cn_master_cityadmin::class,'cityAdminAction'])->name('cityadmin.action');
	Route::get('cityadmin-datatable', [App\Http\Controllers\admin\Cn_master_cityadmin::class, 'get_data_table_of_city_admin'])->name('cityadmin.getDataTable');
	Route::get('edit-cityadmin/{id}', [App\Http\Controllers\admin\Cn_master_cityadmin::class, 'fun_edit_city_admin']);
	
	// Categories Routes
	Route::get('categories', [App\Http\Controllers\admin\Cn_categories::class,'index'])->name('main.categories');
	Route::post('category-action', [App\Http\Controllers\admin\Cn_categories::class,'categoryAction'])->name('category.action');
	Route::get('category-datatable', [App\Http\Controllers\admin\Cn_categories::class, 'get_data_table_of_category'])->name('category.getDataTable');
	Route::get('edit-categoryadmin/{id}', [App\Http\Controllers\admin\Cn_categories::class, 'fun_edit_category']);



	// Wallet Normal Routes
	Route::get('normal-plan', [App\Http\Controllers\admin\Cn_wallet_offers::class,'index'])->name('wallet.normal.plan');
	Route::post('normal-plan-action', [App\Http\Controllers\admin\Cn_wallet_offers::class,'normalPlanAction'])->name('wallet.normal.plan.action');
	Route::get('normal-plan-datatable', [App\Http\Controllers\admin\Cn_wallet_offers::class, 'get_data_table_of_normal_plan'])->name('normal.plan.getDataTable');
	Route::post('check-duplicate-plan', [App\Http\Controllers\admin\Cn_wallet_offers::class,'check_duplicate_plan_amount']);
	Route::get('edit-normal-plan/{id}', [App\Http\Controllers\admin\Cn_wallet_offers::class, 'fun_edit_wallet_normal_plan']);


	// wallet offer plan routes
	Route::get('offer-plan-page', [App\Http\Controllers\admin\cn_wallet_offers::class,'offer_plan_page'])->name('offer.plan.page');
	Route::get('admin/add-offerplan', [App\Http\Controllers\admin\cn_wallet_offers::class,'add_offerplan'])->name('add.offerplan');
	Route::post('offerplan-action', [App\Http\Controllers\admin\cn_wallet_offers::class,'offerPlanAction'])->name('offerplan.action');
	Route::get('offerplan-datatable', [App\Http\Controllers\admin\cn_wallet_offers::class, 'get_data_table_of_offer_plan'])->name('offerplan.getDataTable');
	Route::get('edit-offer-plan/{id}', [App\Http\Controllers\admin\cn_wallet_offers::class, 'fun_edit_offer_plan']);



	// Main Banner Routes
	Route::get('city-admin', [App\Http\Controllers\admin\Cn_master_cityadmin::class,'index'])->name('city.admin');

	// Banner Routes
	Route::get('banner', [App\Http\Controllers\admin\Cn_banner::class,'index'])->name('main.banner');
	Route::post('banner-action', [App\Http\Controllers\admin\Cn_banner::class,'bannerAction'])->name('banner.action');
	Route::get('bannermaster-datatable', [App\Http\Controllers\admin\Cn_banner::class, 'get_data_table_of_banner_master'])->name('bannermaster.getDataTable');
	Route::get('edit-banner/{id}', [App\Http\Controllers\admin\Cn_banner::class, 'fun_edit_banner']);


	// Order routes
	Route::get('ongoing-orders', [App\Http\Controllers\admin\Cn_ongoing_orders::class,'index'])->name('ongoing.orders');
	Route::get('completed-orders', [App\Http\Controllers\admin\Cn_completed_orders::class,'index'])->name('completed.orders');
	Route::get('cancelled-orders', [App\Http\Controllers\admin\Cn_cancelled_orders::class,'index'])->name('cancelled.orders');
	Route::get('returned-orders', [App\Http\Controllers\admin\Cn_returned_orders::class,'index'])->name('returned.orders');

	//Content Management
	Route::get('about-us', [App\Http\Controllers\admin\Cn_aboutus_term_condition::class,'index'])->name('about.us');
	
	Route::get('terms-condition', [App\Http\Controllers\admin\Cn_aboutus_term_condition::class,'terms_condition_page'])->name('terms.condition');
	Route::get('privacy_policy', [App\Http\Controllers\admin\Cn_aboutus_term_condition::class,'privacy_policy_page'])->name('privacy.policy');

	Route::post('cms-action', [App\Http\Controllers\admin\Cn_aboutus_term_condition::class,'cmsAction'])->name('cms.action');

	// Withdrwal Request routes
	Route::get('city-admin-withdrwal', [App\Http\Controllers\admin\Cn_withdrwal_request::class,'index'])->name('city.admin.withdrwal');
	Route::get('vendor-withdrwal', [App\Http\Controllers\admin\Cn_withdrwal_request::class,'vendor_withdrwal_page'])->name('vendor.withdrwal');
	Route::get('delivery-boy-withdrwal', [App\Http\Controllers\admin\Cn_withdrwal_request::class,'delivery_boy_withdrwal_page'])->name('delivery.boy.withdrwal');

	// Account Settlement routes
	Route::get('city-admin-account-settlement', [App\Http\Controllers\admin\Cn_account_settlement::class,'index'])->name('city.admin.account.settlement');
	Route::get('vendor-account-settlement', [App\Http\Controllers\admin\Cn_account_settlement::class,'vendor_account_settlement_page'])->name('vendor.account.settlement');
	Route::get('delivery-boy-account-settlement', [App\Http\Controllers\admin\Cn_account_settlement::class,'delivery_boy_account_settlement_page'])->name('delivery.boy.account.settlement');



	// On screen notification route
	Route::get('user-notification', [App\Http\Controllers\admin\Cn_notification::class,'fun_user_notification'])->name('user.notification');
	Route::post('notification-action', [App\Http\Controllers\admin\Cn_notification::class,'userNotificationAction']);
Route::get('notification-datatable/{user_type}', [App\Http\Controllers\admin\Cn_notification::class, 'get_data_table_of_notification']);
	
	Route::get('vendor-notification', [App\Http\Controllers\admin\Cn_notification::class,'fun_vendor_notification'])->name('vendor.notification');


	Route::get('delivery-boy-notification', [App\Http\Controllers\admin\Cn_notification::class,'fun_delivery_boy_notification'])->name('delivery.boy.notification');
	
	// Reward, Redeem Point all routes

	Route::get('redeem-points', [App\Http\Controllers\admin\Cn_reward_redeem_points::class,'fun_redeem_point'])->name('redeem.points');
	Route::post('cms-points-action', [App\Http\Controllers\admin\Cn_reward_redeem_points::class,'cmsPointsAction'])->name('cms.points.action');
	Route::get('reward-points', [App\Http\Controllers\admin\Cn_reward_redeem_points::class,'fun_reward_point'])->name('reward.points');
	


});