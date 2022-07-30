<?php

namespace App\Models\vendor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Md_vendor_category_master extends Model
{
    
    use HasFactory;
    protected $guard = 'vendor';
    protected $table ='mangao_vendor_category_master'; 
    public $timestamps = false;

    protected $fillable = [
        'vendor_category_name', 'vendor_category_image', 'category_type',
    ];
    protected $hidden = [
        'remember_token',
    ];


     public function getVendorCategoryImageAttribute($value)
    {
        return $url = !empty($value) ? url('/'). Storage::url($value) : '';
    }

    
}
