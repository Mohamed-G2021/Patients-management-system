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
        Schema::create('ovarian_cancer_history_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')
            ->constrained('ovarian_cancer_tests')
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
            $table->boolean('breast_cancer_history')->nullable();
            $table->boolean('relatives_with_ovarian_cancer')->nullable();
            $table->boolean('gene_mutation_or_lynch_syndrome')->nullable();
            $table->string('tvs_result')->nullable();
            $table->string('tvs_comment')->nullable();
            $table->string('ca-125_result')->nullable();
            $table->string('ca-125_comment')->nullable();
            $table->string('recommendations')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ovarian_cancer_history_tests');
    }
};
