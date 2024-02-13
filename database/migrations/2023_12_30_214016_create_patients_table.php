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
            $table->integer('age');
            $table->string('phone_number');
            $table->integer('patient_code')->unique();
            $table->string('date_of_birth');
            $table->string('address')->nullable();
            $table->string('marital_state');
            $table->string('relative_name')->nullable();
            $table->string('relative_phone')->nullable();
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
