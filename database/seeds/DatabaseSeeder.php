<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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

        $path2 = public_path('sql/ad_supamallproduct.sql');
        $sql2 = file_get_contents($path2);
        DB::unprepared($sql2);
        
    }
}
