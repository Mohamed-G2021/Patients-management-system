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
        Schema::create('general_examination_history_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')
            ->constrained('general_examination_tests')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->float('height');
            $table->integer('pulse');
            $table->float('weight');
            $table->float('random_blood_sugar');
            $table->string('blood_pressure');
            $table->json('investigationFiles')->nullable();
            $table->foreignId('patient_id')
            ->constrained('patients')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_examination_history_tests');
    }
};
