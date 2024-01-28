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
            $table->float('weight');
            $table->boolean('current_oestrogen_use');
            $table->string('recommendations');
            $table->string('investigation');
            $table->timestamps();
            $table->foreignId('patient_id')
            ->constrained('patients')
            ->onUpdate('cascade')
            ->onDelete('cascade');
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
