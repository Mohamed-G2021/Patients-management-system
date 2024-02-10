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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('national_id');
            $table->string('name');
            $table->string('age');
            $table->string('phone_number');
            $table->integer('patient_id')->unique();
            $table->string('date_of_birth');
            $table->string('address');
            $table->string('marital_state');
            $table->string('relative_name');
            $table->string('relative_phone');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
