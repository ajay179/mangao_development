<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Md_bell_icon_notification_master extends Model
{
    use HasFactory;
    protected $table ='mangao_bell_icon_notification_master';    
    public $timestamps = false;
    protected $fillable = [
        'user_type', 'notification_title', 'message','notification_image','city_id','created_at','created_by','created_ip_address','category_type_id','category_type','created_user_type'
    ];

    protected $hidden = [
        'remember_token',
    ];
}
