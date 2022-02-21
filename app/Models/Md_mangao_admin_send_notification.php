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
        'user_type', 'notification_title', 'message',
    ];
    
    
}
