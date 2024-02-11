<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;
use Illuminate\Support\Carbon;



class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker =  Factory::create('pl_PL');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('cities')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        for($i=1;$i<=20;$i++)
        {
            DB::table('cities')->insert([
                'city_name' => $faker->city(),
                'created_at'=>Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }
    }    
}
