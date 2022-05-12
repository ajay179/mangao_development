<?php

namespace App\Models\vendor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Md_mangao_vendor_promotional_banner extends Model
{
    use HasFactory;

    protected $guard = 'vendor';
    protected $table ='mangao_vendor_promotional_banner'; 
    public $timestamps = false;

    protected $fillable = [
        'promotion_date', 'sloat_id','from_time', 'to_time', 'promotion_banner_image', 'category_type_id','created_by','category_type','created_ip_address','updated_by','updated_ip_address','vendor_id'
    ];
    protected $hidden = [
        'remember_token',
    ];

     public function getPromotionDateAtAttribute($date)
    {
        // return ucfirst($value);
        return $date = !empty($date) ? date('d M Y',strtotime($date)) : '';
    }
}
