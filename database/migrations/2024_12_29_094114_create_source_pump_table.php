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
        Schema::create('source_pump', function (Blueprint $table) {
            $table->foreignId('source_id')->constrained('sources')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('pump_id')->constrained('pumps')->onDelete('cascade')->onUpdate('cascade');
            $table->primary(['source_id','pump_id']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('source_pump');
    }
};
