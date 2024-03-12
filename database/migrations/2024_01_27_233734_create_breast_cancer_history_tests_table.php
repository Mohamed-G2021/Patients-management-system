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
        Schema::create('breast_cancer_history_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')
            ->constrained('breast_cancer_tests')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreignId('patient_id')
            ->constrained('patients')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreignId('doctor_id')
            ->constrained('users')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->integer('age');
            $table->enum('family_history',
            [
            'negative',
            'positive in second degree relatives (any number)',
            'positive in one first degree relatives',
            'positive in more than one first degree relatives'
            ])
            ->nullable();
            $table->string('recommendations')->nullable();
            $table->string('investigation_files')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('breast_cancer_history_tests');
    }
};
