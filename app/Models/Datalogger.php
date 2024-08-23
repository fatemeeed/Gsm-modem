<?php

namespace App\Models;

use App\Models\Message;
use App\Models\OrderCode;
use PhpParser\Node\Stmt\Switch_;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Datalogger extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dataloggers';

    protected $guarded = ['id'];

    protected $casts=['content'=> array() ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
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


    public function checkCodes()
    {
        return $this->belongsToMany(CheckCode::class);
    }

    public function getDeviceSahpeAttribute()
    {
        switch ($this->type) {
            case '0':
                $resualt = 'pump';
                break;
            case '1':
                $resualt = 'pit';
                break;
            case '2':
                $resualt = 'source';
                break;
        }

        return $resualt;
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function lastRecieveMessage()
    {
        return $this->messages()->latest('time')->first() ;
    }

    public function dataloggerLastStatus()
    {
      
        
        return $this->lastRecieveMessage()->content[$this->powerCheckCode->name]  ?? 'NoConnect';
    }

    public function sourceVolumePercentage()
    {
        if ($this->dataloggerLastStatus() =='ON') {
            
          
            $currentHeight =str_replace('meter','',$this->lastRecieveMessage()->content['Height']) ;
            $baseHeight = $this->fount_height;
            $persent = round(($currentHeight / $baseHeight)* 100, 0) ;
            
           
        }
        else{
            $persent=0;
        }

        return $persent;
        
    }


    public function powerCheckCode()
    {
        return $this->belongsTo(CheckCode::class, 'power');
    }

    public function order_codes()
    {
        return $this->belongsToMany(OrderCode::class)->withPivot('time', 'last_sent_at');
    }
}
