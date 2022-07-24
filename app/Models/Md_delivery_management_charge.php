<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Md_delivery_management_charge extends Model
{
    use HasFactory;

    protected $table ='mangao_cityadmin_delivery_charge_manage'; 
    
    protected $fillable = [
        'upto_3_km_charge', 'charge_after_3_km','deli_boy_charge_upto_3km','deli_boy_charge_after_3km','created_by','created_ip_address'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
}
