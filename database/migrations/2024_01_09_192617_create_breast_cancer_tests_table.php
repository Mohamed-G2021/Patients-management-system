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
        Schema::create('breast_cancer_tests', function (Blueprint $table) {
            $table->id();
            $table->integer('age');
            $table->string('family_history');
            $table->string('recommendations');
            $table->string('investigation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('breast_cancer_tests');
    }
};
