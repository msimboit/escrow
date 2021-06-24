<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DB;

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
