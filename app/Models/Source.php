<?php

namespace App\Models;

use App\Models\Pump;
use App\Models\Well;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Scopes\ForUserIndustrialCityScope;
use Illuminate\Database\Eloquent\SoftDeletes;

class Source extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];

    public function datalogger()
    {
        return $this->morphOne(Datalogger::class, 'dataloggerable');
    }

    public function industrialCity()
    {
        return $this->belongsTo(IndustrialCity::class);
    }

    public function wells()
    {
        return $this->belongsToMany(Well::class, 'source_well', 'source_id', 'well_id');
    }

    public function pumps()
    {
        return $this->belongsToMany(Pump::class, 'source_pump', 'source_id', 'pump_id');
    }

    protected static function booted()
    { 
        static::addGlobalScope(new ForUserIndustrialCityScope);
        
    }


    
}
