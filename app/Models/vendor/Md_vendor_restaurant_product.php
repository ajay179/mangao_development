<?php

namespace App\Models\vendor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Md_vendor_restaurant_product extends Model
{
    use HasFactory;

    protected $guard = 'vendor';
    protected $table ='mangao_vendor_restaurant_product'; 
    public $timestamps = false;

    protected $fillable = [
        'vendor_category_id', 'product_name','quantity', 'price', 'offer_price','product_description', 'unit','product_image','created_by','category_type','created_ip_address','updated_by','updated_ip_address','vendor_id'
    ];
    protected $hidden = [
        'remember_token',
    ];


}
