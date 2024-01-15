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
        Schema::create('generalexaminations', function (Blueprint $table) {
            $table->id();
            $table->float('height');
            $table->integer('pulse');
            $table->float('weight');
            $table->float('random_blood_sugar');
            $table->string('blood_pressure');
            $table->string('investigation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generalexaminations');
    }
};