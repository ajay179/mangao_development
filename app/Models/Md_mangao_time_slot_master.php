<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Md_mangao_time_slot_master extends Model
{
    use HasFactory;
    protected $table ='mangao_time_slot_master'; 
    public $timestamps = false;

    protected $fillable = [
        'from_time', 'to_time', 'slot_category','slot_name','created_by','category_type','created_ip_address','updated_by','updated_ip_address'
    ];

    protected $hidden = [
        'remember_token',
    ];
}
