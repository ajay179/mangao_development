<?php

namespace App\Models\vendor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Md_mangao_vendor_banner extends Model
{
    use HasFactory;
    protected $guard = 'vendor';
    protected $table ='mangao_vendor_my_banner'; 
    public $timestamps = false;

    protected $fillable = [
        'created_by', 'vendor_banner_img',
    ];
    protected $hidden = [
        'remember_token',
    ];


    /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function getVendorBannerImgAttribute($value)
    {
        // return ucfirst($value);
        return $url = !empty($value) ? url('/'). Storage::url($value) : '';
    }
}
