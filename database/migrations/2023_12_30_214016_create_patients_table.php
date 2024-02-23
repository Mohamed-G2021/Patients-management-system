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
            $table->string('national_id')->required();
            $table->string('name')->required();
            $table->integer('age')->required();
            $table->string('phone_number')->required();
            $table->integer('patient_code')->unique()->required();
            $table->string('date_of_birth')->required();
            $table->string('address')->nullable();
            $table->string('marital_state')->required();
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
