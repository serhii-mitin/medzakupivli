<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vaccine_doses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('vaccine_id')
                ->constrained('vaccines')
                ->onDelete('cascade');

            $table->string('serial_number', 255)->unique();
            $table->date('expiration_date');
            $table->unsignedSmallInteger('status')->default(\App\Utils\Enums\Vaccine\VaccineDoseStatus::NEW);
            $table->date('used_date')->nullable();
            $table->unsignedSmallInteger('volume');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccine_doses');
    }
};
