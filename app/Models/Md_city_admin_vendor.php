<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
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

    /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function getVendorImageAttribute($value)
    {
        // return ucfirst($value);
        return $url = !empty($value) ? url('/'). Storage::url($value) : '';
    }

    public function getCreatedAtAttribute($date)
    {
        // return ucfirst($value);
        return $date = !empty($date) ? date('d M Y',strtotime($date)) : '';
    }

    
}
