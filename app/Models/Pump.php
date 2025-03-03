<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\ForUserIndustrialCityScope;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pump extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];

    public function industrialCity()
    {
        return $this->belongsTo(IndustrialCity::class);
    }

    


    public function datalogger()
    {
        return $this->morphOne(Datalogger::class, 'dataloggerable');
    }
    public function sources()
    {
        return $this->belongsToMany(Source::class, 'source_pump', 'pump_id', 'source_id');
    }

    protected static function booted()
    {
        static::addGlobalScope(new ForUserIndustrialCityScope);
    }
}
