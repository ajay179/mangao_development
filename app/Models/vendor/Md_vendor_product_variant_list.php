<?php

namespace App\Models\vendor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Md_vendor_product_variant_list extends Model
{
    use HasFactory;
    protected $guard = 'vendor';
    protected $table ='mangao_vendor_product_variant_list'; 
    public $timestamps = false;

    protected $fillable = [
        'vendor_id', 'product_id', 'variant_quantity','variant_price', 'variant_offer_price', 'variant_unit','variant_stock', 'category_type'
    ];
    protected $hidden = [
        'remember_token',
    ];
}
