<?php

namespace Database\Seeders;

use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserRolesSeeder::class);

        if (in_array(config('app.env'), ['local'])) {
            $this->call(MedicalFacilitiesSeeder::class);
            $this->call(PatientsSeeder::class);
            $this->call(VaccinesSeeder::class);
            $this->call(VaccinesDosesSeeder::class);
            $this->call(VaccinesDosesToMedicalFacilitiesSeeder::class);
        }
    }
}
