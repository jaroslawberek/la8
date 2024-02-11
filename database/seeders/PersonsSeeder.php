<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;
use Illuminate\Support\Carbon;

class PersonsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker =  Factory::create('pl_PL');
        DB::table('people')->truncate();
        for ($i = 1; $i <= 10; $i++) {
            DB::table('people')->insert([
                'person_type_id' => random_int(1, 4),
                'city_id' => random_int(1, 20),
                'firstName' => $faker->firstName() ,
                'lastName' => $faker->lastName,
                'phonenumber' => $faker->phoneNumber(),
                'sex' => $faker->randomElement(['male', 'famale']),
                'born' => $faker->dateTimeBetween()->format('Y-m-d'),
                'email' => $faker->email(),
                'pesel' => $faker->numerify('###########'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'photo' => 'empty',
                
            ]);
        }
    }
}
