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
        Schema::create('obstetric_history_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')
            ->constrained('obstetric_tests')
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
            $table->integer('gravidity')->nullable();
            $table->integer('parity')->nullable();
            $table->integer('abortion')->nullable();
            $table->string('notes')->nullable();
            $table->string('investigation_files')->nullable();   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obstetric_history_tests');
    }
};
