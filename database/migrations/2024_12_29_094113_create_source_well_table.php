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
        Schema::create('source_well', function (Blueprint $table) {
            $table->foreignId('source_id')->constrained('sources')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('well_id')->constrained('wells')->onDelete('cascade')->onUpdate('cascade');
            $table->primary(['source_id','well_id']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('source_well');
    }
};
