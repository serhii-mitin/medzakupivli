<?php

namespace Database\Seeders;

use App\Models\VaccineDose;
use Illuminate\Database\Seeder;

class VaccinesDosesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VaccineDose::factory()->count(100)->create();
    }
}
