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
        \App\Models\User::factory(10)->create();
        \App\Models\School::factory(7)->create();
        \App\Models\Subject::factory(10)->create();
        \App\Models\Combination::factory(5)->create();
        \App\Models\Marks::factory(50)->create();
    }
}
