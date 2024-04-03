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
        Schema::create('messages', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('from');
            $table->foreignId('datalogger_id')->constrained('dataloggers')->onDelete('cascade')->onUpdate('cascade');
            $table->text('content');
            $table->string('date');
            $table->string('time');
            $table->tinyInteger('type');
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
        Schema::dropIfExists('messages');
       
    }
};
