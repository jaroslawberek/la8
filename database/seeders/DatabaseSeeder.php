<?php

namespace Database\Seeders;

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
        $this->call(PersonTypesSeeder::class); 
        $this->call(CitiesSeeder::class); 
        $this->call(PersonsSeeder::class); 
    }
}
