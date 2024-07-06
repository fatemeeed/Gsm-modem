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
        Schema::create('check_code_datalogger', function (Blueprint $table) {
            $table->foreignId('check_code_id')->constrained('check_codes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('datalogger_id')->constrained('dataloggers')->onDelete('cascade')->onUpdate('cascade');
            $table->primary(['check_code_id','datalogger_id']);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_code_datalogger');
    }
};
