<?php

namespace App\Models;

use App\Models\Datalogger;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded=['id'];

    public function datalogger()
    {
        return $this->belongsTo(Datalogger::class);
    }
}
