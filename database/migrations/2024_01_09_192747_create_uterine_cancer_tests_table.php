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
        Schema::create('uterine_cancer_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')
            ->constrained('patients')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->enum('lynch_syndrome',['+ve', '-ve'])->nullable();
            $table->boolean('irregular_bleeding')->nullable();
            $table->string('tvs_perimetrium_result')->nullable();
            $table->string('tvs_myometrium_result')->nullable();
            $table->string('tvs_endometrium_result')->nullable();
            $table->string('biopsy_result')->nullable();
            $table->string('biopsy_comment')->nullable();
            $table->string('tvs_perimetrium_comment')->nullable();
            $table->string('tvs_myometrium_comment')->nullable();
            $table->string('tvs_endometrium_comment')->nullable();
            $table->json('investigation_files')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uterine_cancer_tests');
    }
};
