<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = Crypt::encrypt('password'); 

        DB::table('users')->insert([
            'first_name' => 'admin',                      
            'middle_name' => 'admin',                      
            'last_name' => 'admin',                      
            'role' => 'admin',
            'email' => 'admin@gmail.com',          
            'password' => $password,
        ]);
      
    }
}
