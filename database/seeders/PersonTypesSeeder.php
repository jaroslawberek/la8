<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;
use Illuminate\Support\Carbon;


class PersonTypesSeeder extends Seeder
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
        DB::table('person_types')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
            DB::table('person_types')->insert([
                'type_name' => 'pracownik',
                'created_at'=>Carbon::now()->format('Y-m-d H:i:s'),
                'icon'=>'empty'
            ]);
            DB::table('person_types')->insert([
                'type_name' => 'klient',
                'created_at'=>Carbon::now()->format('Y-m-d H:i:s'),
                'icon'=>'empty'
            ]);
            DB::table('person_types')->insert([
                'type_name' => 'najemca',
                'created_at'=>Carbon::now()->format('Y-m-d H:i:s'),
                'icon'=>'empty'
            ]);
            DB::table('person_types')->insert([
                'type_name' => 'wykonawca',
                'created_at'=>Carbon::now()->format('Y-m-d H:i:s'),
                'icon'=>'empty'
            ]);
        
    }
}
