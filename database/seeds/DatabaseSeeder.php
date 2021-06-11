<?php

use Illuminate\Database\Seeder;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);\
        $path = public_path('sql/ad_supamalluser.sql');
        $sql = file_get_contents($path);
        DB::unprepared($sql);
    }
}
