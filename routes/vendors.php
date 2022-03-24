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
		if (session()->has('&%*$^vendorusername$%#','&&*id$##')) {
			Session::flush();
		}
		return redirect('/vendor-login');
	})->can('isVendorAdmin');
	
Route::post('check-login-for-vendor',[App\Http\Controllers\vendor\Cn_login::class,'vendor_login']);

Route::group(['middleware'=>['isVendor','can:isVendorAdmin']], function(){

		//Vendor dashboard route
		Route::get('vendor-dashbord', [App\Http\Controllers\vendor\Cn_vendor_dashboard::class,'index']);

		// Vendor Soft delete common function
		Route::post('soft-delete-of-vendor', [App\Http\Controllers\Cn_vendor_common_controller::class, 'delete_common_function_vendor']);

		//Vendor Category 
		Route::get('vendor-category', [App\Http\Controllers\vendor\Cn_category_master::class,'index'])->name('vendor.category');
		Route::post('vendor-category-action', [App\Http\Controllers\vendor\Cn_category_master::class,'vendorCategoryAction'])->name('vendor.category.action');
		Route::get('vendor-category-datatable', [App\Http\Controllers\vendor\Cn_category_master::class, 'get_data_table_of_vendor_category'])->name('vendor.category.getDataTable');
		Route::get('edit-vendor-category/{id}', [App\Http\Controllers\vendor\Cn_category_master::class,'fun_edit_vendor_category']);


		//Vendor Sub Category 
		Route::get('vendor-sub-category', [App\Http\Controllers\vendor\Cn_sub_category_master::class,'index'])->name('vendor.sub.category')->can('isVendorGrocery');
		Route::post('vendor-sub-category-action', [App\Http\Controllers\vendor\Cn_sub_category_master::class,'vendorSubCategoryAction'])->name('vendor.sub.category.action')->can('isVendorGrocery');
		Route::get('vendor-sub-category-datatable', [App\Http\Controllers\vendor\Cn_sub_category_master::class, 'get_data_table_of_vendor_sub_category'])->name('vendor.sub.category.getDataTable')->can('isVendorGrocery');
		Route::get('edit-sub-vendor-category/{id}', [App\Http\Controllers\vendor\Cn_sub_category_master::class,'fun_edit_sub_vendor_category'])->can('isVendorGrocery');


		// Grocery Vendor Product 
		Route::get('vendor-product', [App\Http\Controllers\vendor\Cn_vendor_product::class,'index'])->name('vendor.product')->can('isVendorGrocery');
		Route::get('vendor-add-product', [App\Http\Controllers\vendor\Cn_vendor_product::class,'fun_add_product'])->name('vendor.add.product')->can('isVendorGrocery');
		Route::post('vendor-add-product-action', [App\Http\Controllers\vendor\Cn_vendor_product::class,'vendorAddProductAction'])->name('vendor.add.product.action')->can('isVendorGrocery');
		
		Route::post('get-sub-category-list-on-category-id', [App\Http\Controllers\vendor\Cn_vendor_product::class,'get_sub_category_list_on_category_id'])->can('isVendorGrocery');
		Route::get('vendor-product-datatable', [App\Http\Controllers\vendor\Cn_vendor_product::class, 'get_data_table_of_vendor_product'])->name('vendor.product.getDataTable')->can('isVendorGrocery');
		Route::get('edit-product/{id}', [App\Http\Controllers\vendor\Cn_vendor_product::class,'fun_edit_product'])->can('isVendorGrocery');
		
		// Vendor product variant route
		Route::get('add-product-variant/{id}', [App\Http\Controllers\vendor\Cn_vendor_product::class,'fun_add_product_variant'])->can('isVendorGrocery');
		Route::post('vendor-add-product-variant-action', [App\Http\Controllers\vendor\Cn_vendor_product::class,'vendorAddProductVariantAction'])->name('vendor.add.product.variant.action')->can('isVendorGrocery');

		Route::get('edit-product-variant/{product_id}/{id}', [App\Http\Controllers\vendor\Cn_vendor_product::class,'fun_edit_product_variant'])->can('isVendorGrocery');
		
		

		// Restaurant Vendor product 

		Route::get('vendor-restaurant-product', [App\Http\Controllers\vendor\Cn_vendor_product::class,'fun_vendor_restaurant_product'])->name('vendor.restaurant.product')->can('isVendorRestaurant');
		Route::get('vendor-add-restaurant-product', [App\Http\Controllers\vendor\Cn_vendor_product::class,'fun_add_restaurant_product'])->name('vendor.add.restaurant.product')->can('isVendorRestaurant');
		Route::post('vendor-add-restaurant-product-action', [App\Http\Controllers\vendor\Cn_vendor_product::class,'vendorAddRestaurantProductAction'])->name('vendor.add.restaurant.product.action')->can('isVendorRestaurant');

});
	


