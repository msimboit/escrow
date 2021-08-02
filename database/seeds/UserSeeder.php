<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;
use DB;
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
        DB::table('users')->truncate();

        DB::table('users')->insert([
            'first_name' => 'admin',
            'middle_name' => 'admin',
            'last_name' => 'admin',
            'phone_number' => '070011223344',
            'email' => 'admin@admin.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        DB::table('users')->insert([
            'first_name' => 'John',
            'middle_name' => 'jj',
            'last_name' => 'Doe',
            'phone_number' => '071122334455',
            'email' => 'johndoe@escrow.com',
            'role' => 'vendor',
            'password' => Hash::make('password'),
        ]);

         DB::table('users')->insert([
            'first_name' => 'Jane',
            'middle_name' => 'jay',
            'last_name' => 'Doe',
            'phone_number' => '072233445566',
            'email' => 'janedoe@escrow.com',
            'role' => 'vendor',
            'password' => Hash::make('password'),
        ]);

        DB::table('users')->insert([
            'first_name' => 'Papa',
            'middle_name' => 'voo',
            'last_name' => 'Tunde',
            'phone_number' => '073344556677',
            'email' => 'papatunde@escrow.com',
            'role' => 'client',
            'password' => Hash::make('password'),
        ]);

        DB::table('users')->insert([
            'first_name' => 'Mama',
            'middle_name' => 'voo',
            'last_name' => 'Tunde',
            'phone_number' => '074455667788',
            'email' => 'mamatunde@escrow.com',
            'role' => 'client',
            'password' => Hash::make('password'),
        ]);
        
    }
}
