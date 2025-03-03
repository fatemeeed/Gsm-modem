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

    public function datalogger()
    {
        return $this->belongsToMany(Datalogger::class)->withPivot(['time','last_sent_at','status']);
    }

    public function getReadableTimeAttribute()
    {
        // جدول مقادیر زمان
        $timeCycle = [
            0 => 'دستی',
            60 => 'هر 60 دقیقه',
            30 => 'هر 30 دقیقه',
            15 => 'هر 15 دقیقه',
            10 => 'هر 10 دقیقه',
        ];

        // مقدار time از pivot استخراج می‌شود
        return $timeCycle[$this->pivot->time] ?? 'نامشخص';
    }

    
}
