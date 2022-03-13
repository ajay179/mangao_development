<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
  //       DB::table('users')->insert([
		//     'name' => 'Ajay Prajapati',
		//     'email' => 'ajay@gmail.com',
		//     'password' => Hash::make('12345')
		// ]);

        DB::table('users')->insert([
            'name' => 'Ajay Prajapati',
            'email' => 'samiksha@gmail.com',
            'password' => Hash::make('12345')
        ]);
    }
}
