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
        Schema::create('sources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('industrial_city_id')->constrained('industrial_cities')->onDelete('cascade')->onUpdate('cascade');
            $table->string('name');
            $table->string('mobile_number');
            $table->string('datalogger_model');
            $table->string('sensor_type');
            $table->foreignId('power')->nullable()->constrained('check_codes')->onDelete('cascade')->onUpdate('cascade');
            $table->string('fount_height')->nullable()->comment('ارتفاع منبع');
            $table->string('fount_bulk')->nullable()->comment('حجم منبع');
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
        Schema::dropIfExists('sources');
    }
};
