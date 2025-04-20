<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataloggerOrderCode extends Model
{
    use HasFactory;

    protected $table = 'datalogger_order_code';

    protected $fillable = ['datalogger_id', 'order_code_id', 'time'];

    protected $with = ['time'];


    public static $timeCycle = [
        '0' => 'دستی',
        '60' => 'هر 60 دقیقه',
        '30' => 'هر 30 دقیقه',
        '15' => 'هر 15 دقیقه',
        '10' => 'هر 10 دقیقه'
    ];

    public function datalogger()
    {
        return $this->belongsTo(Datalogger::class, 'datalogger_id');
    }

    public function orderCode()
    {
        return $this->belongsTo(OrderCode::class, 'order_code_id');
    }

    public function getReadableTimeAttribute()
    {
        return self::$timeCycle[$this->pivot->time] ?? 'نامشخص';
    }

}
