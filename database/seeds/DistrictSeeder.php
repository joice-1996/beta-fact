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
            ['distrcit_name'=>'Kottayam',
            'status'=>1],
            ['distrcit_name'=>'Kollam',
            'status'=>1],
            ['distrcit_name'=>'Alappuzha',
            'status'=>1],
            ['distrcit_name'=>'Pathanamthitta',
            'status'=>1],
            ['distrcit_name'=>'Thiruvananthapuram',
            'status'=>1],
            ['distrcit_name'=>'Malappuram',
            'status'=>1],
            ['distrcit_name'=>'Ernakulam',
            'status'=>1],
            ['distrcit_name'=>'Palakkadu',
            'status'=>1],
        ]);
    }
}
