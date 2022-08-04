<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Md_mangao_store_type_master extends Model
{
    use HasFactory;

    protected $table ='mangao_store_type_master'; 
    public $timestamps = false;

    protected $fillable = [
        'store_type_name', 'store_category_id', 'created_by'
    ];

    protected $hidden = [
        'remember_token',
    ];


    // public function store_type_product_list()
    // {
    //     return $this->belongsTo(Md_city_admin_vendor::class);
    // }
}
