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
        Schema::create('general_examinations', function (Blueprint $table) {
            $table->id();
            $table->float('height');
            $table->integer('pulse');
            $table->float('weight');
            $table->float('random_blood_sugar');
            $table->string('blood_pressure');
            $table->json('investigationFiles')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_examinations');
    }
};
