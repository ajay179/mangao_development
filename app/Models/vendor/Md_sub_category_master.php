<?php

namespace App\Models\vendor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Md_sub_category_master extends Model
{
    use HasFactory;
    protected $guard = 'vendor';
    protected $table ='mangao_vendor_sub_category_master'; 
    public $timestamps = false;

    protected $fillable = [
        'vendor_category_id', 'vendor_sub_category_name', 'category_type',
    ];
    protected $hidden = [
        'remember_token',
    ];
}
