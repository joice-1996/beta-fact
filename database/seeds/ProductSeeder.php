<?php

use Illuminate\Database\Seeder;
use App\Modules\Product\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::insert([
            ['category_id'=>'60d1c1331616000070003a72',
            'product_name'=>'Choclate',
            'rate'=>100.00],
            ['category_id'=>'60d1c1331616000070003a72',
            'product_name'=>'Burger',
            'rate'=>40.00]
        ]);
    }
}
