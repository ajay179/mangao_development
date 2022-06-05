<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Md_mangao_categories extends Model
{
    use HasFactory;
    protected $table ='mangao_categories';	
    public $timestamps = false;

    /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function getCategoryImageAttribute($value)
    {
        // return ucfirst($value);
        return $url = !empty($value) ? url('/'). Storage::url($value) : '';
    }
}
