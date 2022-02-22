<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class md_withdrwal_request extends Model
{
    use HasFactory;
    protected $table1 ='mangao_city_admin_withdrwal_request';
    protected $table2 ='mangao_vendor_withdrwal_request';	
    protected $table3 ='mangao_delivery_boy_withdrwal_request';
    
    public $timestamps = false;
}



