<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Md_mangao_banner extends Model
{
    use HasFactory;

    protected $table ='mangao_banner_masters';   
    public $timestamps = false;

    /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function getBannerImageAttribute($value)
    {
        // return ucfirst($value);
        return $url = url('/'). Storage::url($value);
    }
}
