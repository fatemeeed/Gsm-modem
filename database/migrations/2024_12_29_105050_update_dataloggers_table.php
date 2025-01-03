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
        Schema::table('dataloggers', function (Blueprint $table) {
            $table->dropForeign(['city_id']); 
            $table->dropColumn(['type','model','key_type','sensor_type','city_id','fount_height','fount_bulk','yearly_bulk','name']);

            $table->morphs('dataloggerable');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dataloggers', function (Blueprint $table) {
            //
        });
    }
};
