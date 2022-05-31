<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Md_mangao_admin_send_notification extends Model
{
    use HasFactory;
    protected $table ='mangao_admin_send_notification';    
    public $timestamps = false;
    protected $fillable = [
        'user_type', 'notification_title', 'message','notification_image_name','slot_id','slot_name','from_time','to_time','created_at','created_by','created_ip_address','category_type_id','category_type','created_user_type'
    ];

    protected $hidden = [
        'remember_token',
    ];
    
    
}
