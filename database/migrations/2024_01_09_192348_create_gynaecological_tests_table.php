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
        Schema::create('gynaecological_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')
            ->constrained('patients')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreignId('doctor_id')
            ->constrained('users')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->string('date_of_last_period')->nullable();
            $table->string('menstrual_cycle_abnormalities')->nullable();
            $table->boolean('contact_bleeding')->nullable();
            $table->boolean('menopause')->nullable();
            $table->integer('menopause_age')->nullable();
            $table->boolean('using_of_contraception')->nullable();
            $table->enum('contraception_method',['Pills','IUD','Injectable','Other'])->nullable();
            $table->string('other_contraception_method')->nullable();
            $table->json('investigation_files')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gynaecological_tests');
    }
};
