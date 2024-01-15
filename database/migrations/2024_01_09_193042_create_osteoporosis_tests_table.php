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
        Schema::create('osteoporosis_tests', function (Blueprint $table) {
            $table->id();
            $table->integer('age');
            $table->integer('weight');
            $table->boolean('current_oestrogen_use');
            $table->string('recommendations');
            $table->string('investigation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('osteoporosis_tests');
    }
};