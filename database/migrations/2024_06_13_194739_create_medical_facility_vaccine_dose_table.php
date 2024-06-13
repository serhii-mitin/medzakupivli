<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('medical_facility_vaccine_dose', function (Blueprint $table) {
            $table->foreignId('medical_facility_id')
                ->constrained('medical_facilities')
                ->onDelete('cascade');

            $table->foreignId('vaccine_dose_id')
                ->constrained('vaccine_doses')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_facility_vaccine_dose');
    }
};
