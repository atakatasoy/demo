<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Report;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory()->count(40)->seller()->create();
        // User::factory()->count(500)->buyer()->create();
        $factory = Report::factory();

        $factory->count(40)->seller()->dailyReport()->create();
        $factory->count(40)->seller()->weeklyReport()->create();
        $factory->count(40)->seller()->monthlyReport()->create();
        $factory->count(500)->buyer()->monthlyReport()->create();
    }
}