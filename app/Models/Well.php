<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Well extends Model
{
    use HasFactory;

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
        return $this->belongsToMany(Source::class, 'source_well', 'well_id', 'source_id');
    }
}
