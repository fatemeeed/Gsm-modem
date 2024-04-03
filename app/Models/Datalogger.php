<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Stmt\Switch_;

class Datalogger extends Model
{
    use HasFactory;

    protected $table='dataloggers';

    protected $guarded = ['id'];

    public function city()
    {
        return $this->belongsTo(City::class,'city_id');
    }


    public function getDataLoggerTypeAttribute()
    {
        switch ($this->type) {
            case '0':
                $resualt = 'پمپ';
                break;
            case '1':
                $resualt = 'چاه';
                break;
            case '2':
                $resualt = 'منبع';
                break;

           
        }

        return $resualt;
    }
}
