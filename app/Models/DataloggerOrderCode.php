<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataloggerOrderCode extends Model
{
    use HasFactory;

    protected $table='datalogger_order_code';

    protected $fillable=['datalogger_id','order_code_id','time'];

    protected $with = ['time'];

    
}
