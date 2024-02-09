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
            $table->boolean('lynch_syndrome');
            $table->boolean('irregular_bleeding');
            $table->string('tvs_perimetrium_result');
            $table->string('tvs_myometrium_result');
            $table->string('tvs_endometrium_result');
            $table->string('biopsy_result');
            $table->string('biopsy_comment');
            $table->string('tvs_perimetrium_comment');
            $table->string('tvs_myometrium_comment');
            $table->string('tvs_endometrium_comment');
            $table->string('investigation_files')->nullable();
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
