<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(AdminSeeder::class,
            DistrictSeeder::class,
            ShopSeeder::class,
            CategorySeeder::class,
            SubCategorySeeder::class,
            ProductSeeder::class);
    }
}
