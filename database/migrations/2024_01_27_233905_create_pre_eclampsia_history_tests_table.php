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
        Schema::create('pre_eclampsia_history_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')
            ->constrained('pre_eclampsia_tests')
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
            $table->boolean('history_of_pre-eclampsia')->nullable();
            $table->integer('number_of_pregnancies_with_pe')->nullable();
            $table->string('date_of_pregnancies_with_pe')->nullable();
            $table->enum('fate_of_the_pregnancy', ['1 child','> 1 child', 'still birth'])->nullable();
            $table->string('investigation_files')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_eclampsia_history_tests');
    }
};
