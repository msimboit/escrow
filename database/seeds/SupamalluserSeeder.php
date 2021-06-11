<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SupamalluserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = public_path('sql/ad_supamalluser.sql');
        $sql = file_get_contents($path);
        DB::unprepared($sql);
    }
}
