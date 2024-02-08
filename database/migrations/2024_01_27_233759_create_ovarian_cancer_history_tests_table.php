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
            $table->boolean('breast_cancer_history');
            $table->boolean('relatives_with_ovarian_cancer');
            $table->boolean('gene_mutation_or_lynch_syndrome');
            $table->string('tvs_result');
            $table->string('tvs_comment');
            $table->string('ca-125_result');
            $table->string('ca-125_comment');
            $table->string('recommendations');
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
        Schema::dropIfExists('ovarian_cancer_history_tests');
    }
};
