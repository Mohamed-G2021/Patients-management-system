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
        Schema::create('cervix_cancer_history_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')
            ->constrained('cervix_cancer_tests')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->boolean('hpv_vaccine');
            $table->string('via_test_result');
            $table->string('via_test_comment')->nullable();
            $table->string('pap_smear_result');
            $table->string('pap_smear_comment')->nullable();
            $table->string('recommendations');
            $table->string('investigation');
            $table->foreignId('patient_id')
            ->constrained('patients')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreignId('doctor_id')
            ->constrained('users')
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
        Schema::dropIfExists('cervix_cancer_history_tests');
    }
};
