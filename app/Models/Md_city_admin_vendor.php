<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\User as Authenticatable;


class Md_city_admin_vendor extends User
{
    use HasFactory;
    protected $guard = 'vendor';
    protected $table ='mangao_vendors'; 
    public $timestamps = false;

    protected $fillable = [
        'store_name', 'vendor_email', 'password',
    ];
    protected $hidden = [
        'vendor_password', 'remember_token',
    ];
}
