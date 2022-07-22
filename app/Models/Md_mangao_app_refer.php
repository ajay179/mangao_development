<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Md_mangao_app_refer extends Model
{
    use HasFactory;
    protected $table ='mangao_app_refer_setting'; 
    
    protected $fillable = [
        'welcome_coins', 'welcome_coins_text','created_by','created_ip_address'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
}
