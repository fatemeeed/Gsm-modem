<?php

namespace App\Models;

use App\Models\IndustrialCity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    public function industrialCity()
    {
        return $this->belongsTo(IndustrialCity::class);
    }
}
