<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\vendor\Md_vendor_product;


class Md_mangao_product_type_master extends Model
{
    use HasFactory;
    protected $table ='mangao_product_type_master'; 
    public $timestamps = false;

    protected $fillable = [
        'product_category_id', 'product_type_name', 'created_by'
    ];

    protected $hidden = [
        'remember_token',
    ];


    public function product_list_of_product_type()
    {
        return $this->hasMany(Md_vendor_product::class,'product_type_id','id')->with('variant_of_product')->join('mangao_vendor_category_master as MVCM','MVCM.id','mangao_vendor_product.vendor_category_id')->join('mangao_vendor_sub_category_master as MVSCM','MVSCM.id','mangao_vendor_product.vendor_sub_category_id')->select('mangao_vendor_product.id','mangao_vendor_product.vendor_id','mangao_vendor_product.product_name','mangao_vendor_product.product_type_id','mangao_vendor_product.category_type','MVCM.vendor_category_name','mangao_vendor_product.price','mangao_vendor_product.offer_price','mangao_vendor_product.offer_percent','mangao_vendor_product.product_image','MVSCM.vendor_sub_category_name');
    }
}