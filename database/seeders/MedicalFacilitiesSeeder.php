<?php

namespace Database\Seeders;

use App\Models\MedicalFacility;
use Illuminate\Database\Seeder;

class MedicalFacilitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MedicalFacility::factory()->count(10)->create();
    }
}
