<?php

use Illuminate\Database\Seeder;
use App\Modules\Product\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::insert([
           [ 'category_name'=>'food'],
           [ 'category_name'=>'dress'],
           [ 'category_name'=>'phone'],
        ]);
    }
}
