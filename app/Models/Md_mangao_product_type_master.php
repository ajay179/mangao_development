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
        return $this->hasMany(Md_vendor_product::class,'product_type_id','id')->select('id','vendor_id','product_name','product_type_id','category_type');
    }
}
