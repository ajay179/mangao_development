<?php

namespace App\Models\vendor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\vendor\Md_vendor_restaurant_product;
use App\Models\vendor\Md_vendor_pharmacy_product;


class Md_sub_category_master extends Model
{
    use HasFactory;
    protected $guard = 'vendor';
    protected $table ='mangao_vendor_sub_category_master'; 
    public $timestamps = false;

    protected $fillable = [
        'vendor_category_id', 'vendor_sub_category_name', 'category_type',
    ];
    protected $hidden = [
        'remember_token',
    ];


    public function product_list_of_resto_subcategory()
    {
        return $this->hasMany(Md_vendor_restaurant_product::class,'vendor_sub_category_id','id')->join('mangao_vendor_category_master as MVCM','MVCM.id','mangao_vendor_restaurant_product.vendor_category_id')->join('mangao_vendor_sub_category_master as MVSCM','MVSCM.id','mangao_vendor_restaurant_product.vendor_sub_category_id')->select('mangao_vendor_restaurant_product.id','mangao_vendor_restaurant_product.vendor_id','mangao_vendor_restaurant_product.vendor_sub_category_id','mangao_vendor_restaurant_product.product_name','mangao_vendor_restaurant_product.category_type','MVCM.vendor_category_name','mangao_vendor_restaurant_product.price','mangao_vendor_restaurant_product.offer_price','mangao_vendor_restaurant_product.product_image','mangao_vendor_restaurant_product.veg_status','MVSCM.vendor_sub_category_name');
    }


    public function product_list_of_pharmacy_subcategory()
    {
        return $this->hasMany(Md_vendor_pharmacy_product::class,'vendor_sub_category_id','id')->join('mangao_vendor_category_master as MVCM','MVCM.id','mangao_vendor_pharmacy_product.vendor_category_id')->join('mangao_vendor_sub_category_master as MVSCM','MVSCM.id','mangao_vendor_pharmacy_product.vendor_sub_category_id')->select('mangao_vendor_pharmacy_product.id','mangao_vendor_pharmacy_product.vendor_id','mangao_vendor_pharmacy_product.vendor_sub_category_id','mangao_vendor_pharmacy_product.product_name','mangao_vendor_pharmacy_product.category_type','MVCM.vendor_category_name','mangao_vendor_pharmacy_product.price','mangao_vendor_pharmacy_product.offer_price','mangao_vendor_pharmacy_product.product_image','MVSCM.vendor_sub_category_name');
    }

    
}
