<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\facades\DB;
use Illuminate\Support\str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class mangao_static_useradmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Request $request)
    {
       	DB::table('mangao_static_useradmin')->insert([
        	'name'=>'Super Admin',
        	'email'=>'admin@gmail.com',
        	'mobile_number'=>'9878876787',
        	'password'=>Hash::make('admin@123'),
			'created_by'=>'1',
			'created_ip_address'=>$request->ip(),
			'created_at'=> date('Y-m-d h:i:s')

        ]);
    }
}
