<?php

namespace App\Models\vendor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Md_vendor_product extends Model
{
    use HasFactory;
    protected $guard = 'vendor';
    protected $table ='mangao_vendor_product'; 
    public $timestamps = false;

    protected $fillable = [
        'vendor_category_id', 'vendor_sub_category_id', 'product_name','quantity', 'price', 'offer_price','product_description', 'unit', 'stock','product_image','created_by','category_type','created_ip_address','updated_by','updated_ip_address'
    ];
    protected $hidden = [
        'remember_token',
    ];
}
