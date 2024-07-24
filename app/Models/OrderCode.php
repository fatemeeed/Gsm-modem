<?php

namespace App\Models;

use App\Models\Datalogger;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderCode extends Model
{
    use HasFactory,SoftDeletes;

   
    protected $guarded = ['id'];

    public function dataloggers()
    {
        return $this->belongsToMany(Datalogger::class)->withPivot('time','last_sent_at');
    }

    
}
