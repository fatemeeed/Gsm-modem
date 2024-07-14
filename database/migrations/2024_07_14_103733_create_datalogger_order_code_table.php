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
        Schema::create('datalogger_order_code', function (Blueprint $table) {
            $table->foreignId('datalogger_id')->constrained('dataloggers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('order_code_id')->constrained('order_codes')->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['datalogger_id', 'order_code_id']);
            $table->string('time');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datalogger_order_code');
    }
};
