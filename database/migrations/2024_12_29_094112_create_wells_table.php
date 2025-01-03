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
        Schema::create('wells', function (Blueprint $table) {
            $table->id();
            $table->foreignId('industrial_city_id')->constrained('industrial_cities')->onDelete('cascade')->onUpdate('cascade');
            $table->string('name');
            $table->string('mobile_number');
            $table->string('datalogger_model');
            $table->foreignId('power')->nullable()->constrained('check_codes')->onDelete('cascade')->onUpdate('cascade');
            $table->string('flow_rate')->comment('دبی');
            $table->string('yearly_bulk')->comment('حجم برداشت سالانه');
            $table->tinyInteger('status');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wells');
    }
};
