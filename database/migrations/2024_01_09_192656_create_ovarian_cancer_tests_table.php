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
        Schema::create('ovarian_cancer_tests', function (Blueprint $table) {
            $table->id();
            $table->boolean('breast_cancer_history');
            $table->boolean('relatives_with_ovarian_cancer');
            $table->boolean('gene_mutation_or_lynch_syndrome');
            $table->string('tvs_result');
            $table->string('tvs_comment');
            $table->string('ca-125_result');
            $table->string('ca-125_comment');
            $table->string('recommendations');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ovarian_cancer_tests');
    }
};