<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\User as Authenticatable;

class MangaoStaticUseradmin extends User
{
    use HasFactory;
    protected $guard = 'admin';
    protected $table = 'mangao_static_useradmin';
    protected $fillable = [
        'name', 'email', 'password',
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
}
