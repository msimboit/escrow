<?php

use Illuminate\Database\Seeder;
use DB;
use App\Product;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        # Remove all existing entrie
        DB::table('products')->delete() ;
        User::create(
            [
            'name' => 'Laptop',
            'price' => 80000,
            ],
            [
            'name' => 'Phone',
            'price' => 50000,
            ],
            [
            'name' => 'Watch',
            'price' => 5000,
            ],
            [
            'name' => 'Samsung TV',
            'price' => 75000,
            ]
    );
    }
}
