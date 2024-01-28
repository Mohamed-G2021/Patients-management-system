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
        Schema::create('gynaecological_history_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')
            ->constrained('gynaecological_tests')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->string('date_of_last_period');
            $table->string('menstrual_cycle_abnormalities');
            $table->boolean('contact_bleeding');
            $table->boolean('menopause')->nullable();
            $table->integer('menopause_age')->nullable();
            $table->boolean('using_of_contraception')->nullable();
            $table->enum('contraception_method',['Pills','IUD','Injectable','Other'])->nullable();
            $table->string('investigation')->nullable();
            $table->foreignId('patient_id')
            ->constrained('patients')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gynaecological_history_tests');
    }
};
