<?php

use Illuminate\Database\Seeder;
use App\Modules\Order\Models\District as District;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        District::insert([
            ['distrcit_name'=>'Kottayam'],
            ['distrcit_name'=>'Kollam'],
            ['distrcit_name'=>'Alappuzha'],
            ['distrcit_name'=>'Pathanamthitta'],
            ['distrcit_name'=>'Thiruvananthapuram'],
            ['distrcit_name'=>'Malappuram'],
            ['distrcit_name'=>'Ernakulam'],
            ['distrcit_name'=>'Palakkadu'],
        ]);
    }
}
