<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckCode extends Model
{
    use HasFactory;

    protected $guarded=['id'];


    public function dataloggers()
    {
        return $this->belongsToMany(Datalogger::class);
    }
}
