<?php

namespace Database\Seeders;

use App\Models\MedicalFacility;
use App\Models\VaccineDose;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VaccinesDosesToMedicalFacilitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $medicalFacilities = MedicalFacility::all();

        $vaccineDoses = VaccineDose::all()->shuffle();

        foreach ($medicalFacilities as $facility) {
            if ($vaccineDoses->isEmpty()) {
                break;
            }

            $dosesCount = rand(1, min(5, $vaccineDoses->count()));

            $dosesForFacility = $vaccineDoses->splice(0, $dosesCount);

            foreach ($dosesForFacility as $dose) {
                DB::table('medical_facility_vaccine_dose')->insert([
                    'medical_facility_id' => $facility->id,
                    'vaccine_dose_id' => $dose->id
                ]);
            }
        }
    }
}
