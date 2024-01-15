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
        Schema::create('pre_eclampsia_tests', function (Blueprint $table) {
            $table->id();
            $table->boolean('history_of_pre-eclampsia');
            $table->integer('number_of_pregnancies_with_pe');
            $table->string('date_of_pregnancies_with_pe');
            $table->string('fate_of_the_pregnancy');
            $table->string('investigation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_eclampsia_tests');
    }
};
