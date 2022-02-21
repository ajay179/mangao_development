<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\User as Authenticatable;

class Md_city_admin extends User
{
    use HasFactory;
    protected $guard = 'city_admin';
    protected $table ='mangao_city_admins';	
    public $timestamps = false;

    protected $fillable = [
        'admin_name', 'admin_email', 'password',
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
}
