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
        Schema::create('obstetric_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')
            ->constrained('patients')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->integer('gravidity');
            $table->integer('parity');
            $table->integer('abortion');
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
        Schema::dropIfExists('obstetric_tests');
    }
};
