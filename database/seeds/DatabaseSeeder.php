<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeds\SupamallproductSeeder;
use Database\Seeds\SupamalluserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SupamalluserSeeder::class);
        $this->call(SupamallproductSeeder::class);
    }
}
