<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Md_wallet_offer_plan extends Model
{
    use HasFactory;
    protected $table ='mangao_wallet_offers_plan';    
   
    protected $fillable = [
        'offer_amount', 'discount_value_type', 'discount_amount','maximum_offer','created_by','created_ip_address','offer_plan_image'
    ];
}
