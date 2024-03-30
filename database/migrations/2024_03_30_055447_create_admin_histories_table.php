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
        Schema::create('admin_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('admin_id');
            $table->foreignId('doctor_id')
            ->constrained('users')
            ->onUpdate('cascade');
            $table->enum('action', ['added', 'edited', 'deleted']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_histories');
    }
};
