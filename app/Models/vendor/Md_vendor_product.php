<?php

namespace App\Models\vendor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Model\Md_mangao_product_type_master;

class Md_vendor_product extends Model
{
    use HasFactory;
    protected $guard = 'vendor';
    protected $table ='mangao_vendor_product'; 
    public $timestamps = false;

    protected $fillable = [
        'vendor_category_id', 'vendor_sub_category_id', 'product_name','quantity', 'price', 'offer_price','product_description', 'unit', 'stock','product_image','created_by','category_type','created_ip_address','updated_by','updated_ip_address','vendor_id'
    ];
    protected $hidden = [
        'remember_token',
    ];

    //  public function vendor_product_type(){
    //     return $this->belongsTo(Md_mangao_product_type_master::class);
    // }

    public function getProductImageAttribute($value)
    {
        // return ucfirst($value);
        return $url = !empty($value) ? url('/'). Storage::url($value) : '';
    }

    public function variant_of_product()
    {
        return $this->hasMany(Md_vendor_product_variant_list::class,'product_id','id')->select('id','product_id','variant_quantity','variant_price','variant_offer_price','variant_unit');
    }
}
