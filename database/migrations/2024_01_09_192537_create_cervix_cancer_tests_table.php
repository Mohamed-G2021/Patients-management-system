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
        Schema::create('cervix_cancer_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')
            ->constrained('patients')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->boolean('hpv_vaccine')->nullable();
            $table->string('via_test_result')->nullable();
            $table->string('via_test_comment')->nullable();
            $table->string('pap_smear_result')->nullable();
            $table->string('pap_smear_comment')->nullable();
            $table->string('recommendations')->nullable();
            $table->json('investigation_files')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cervix_cancer_tests');
    }
};
