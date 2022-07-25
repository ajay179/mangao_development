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
        'from_time', 'to_time', 'slot_category','slot_name','created_by','category_type','created_ip_address','updated_by','updated_ip_address','max_no_of_banners','banners_1_amount','banners_2_amount','banners_3_amount','banners_4_amount','banners_5_amount',
    ];

    protected $hidden = [
        'remember_token',
    ];
}
