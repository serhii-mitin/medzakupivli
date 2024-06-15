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
        Schema::create('vaccination_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');

            $table->foreignId('medical_facility_id')
                ->nullable()
                ->constrained('medical_facilities')
                ->onDelete('set null');

            $table->foreignId('dose_id')
                ->nullable()
                ->constrained('vaccine_doses')
                ->onDelete('set null');

            $table->timestamp('selected_time');
            $table->timestamp('completed_time')->nullable();

            $table->unsignedSmallInteger('status');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccination_histories');
    }
};
