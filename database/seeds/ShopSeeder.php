<?php

use Illuminate\Database\Seeder;
use App\Modules\Order\Models\Shop;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Shop::insert([
            ['district_id'=>'60d1c1f44e14000093000562',
            'shop_name'=>'Best Bakery'],
            ['district_id'=>'60d1c1f44e14000093000562',
            'shop_name'=>'Kalyan Silks'],
            ['district_id'=>'60d1c1f44e14000093000562',
            'shop_name'=>'Joy Mall'],
            ['district_id'=>'60d1c1f44e14000093000568',
            'shop_name'=>'LuLu Mall']
        ]);
    }
}
