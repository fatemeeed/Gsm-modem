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
        Schema::create('dataloggers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mobile_number')->unique();
            $table->tinyInteger('type');
            $table->string('model');
            $table->tinyInteger('key_type');
            $table->string('sensor_type');
            $table->foreignId('city_id')->constrained('cities')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('power')->nullable()->constrained('check_codes')->onDelete('cascade')->onUpdate('cascade');
            $table->string('fount_height')->nullable()->comment('ارتفاع منبع');
            $table->string('fount_bulk')->nullable()->comment('حجم منبع');
            $table->string('yearly_bulk')->comment('حجم برداشت سالانه');
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dataloggers');
    }
};
