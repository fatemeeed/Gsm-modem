<?php

namespace App\Models;

use App\Models\Province;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;

    protected $table='cities';
    protected $guarded=['id'];


    public function province()
    {
        $this->belongsTo(Province::class);
    }
}
