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
	});
	
Route::post('check-login-for-admin',[App\Http\Controllers\admin\Cn_login::class,'admin_login']);
	

Route::group(['middleware'=>['isAdmin']], function(){

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
	

	// Main Banner Routes
	Route::get('city-admin', [App\Http\Controllers\admin\Cn_master_cityadmin::class,'index'])->name('city.admin');


});