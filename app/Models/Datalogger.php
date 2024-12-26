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

    protected $casts = ['content' => array()];

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
        return $this->messages()->where('type', '1')->latest('time','created_at')->first();
    }

    public function dataloggerLastStatus()
    {


        return $this->lastRecieveMessage()->content[$this->powerCheckCode->name]  ?? 'NoConnect';
    }

    public function sourceVolumePercentage()
    {
        // if ($this->dataloggerLastStatus() == 'ON') {


        //     $currentHeight = str_replace('meter', '', $this->lastRecieveMessage()->content['Height']);
        //     $baseHeight = $this->fount_height;
        //     $persent = round(($currentHeight / $baseHeight) * 100, 0);
        // } else {
        //     $persent = 0;
        // }
 //dd(  $this->lastRecieveMessage());
        $currentHeight = $this->lastRecieveMessage()->content['Level'];

        // $baseHeight = $this->fount_height ?? '';

        // $persent = (($currentHeight / $baseHeight) * 100);

        return $currentHeight;
    }


    public function powerCheckCode()
    {
        return $this->belongsTo(CheckCode::class, 'power');
    }

    public function order_codes()
    {
        return $this->belongsToMany(OrderCode::class)->withPivot('time', 'last_sent_at');
    }


    public function parseMessage($message)
    {
        
        switch ($this->type) {
            case '1':
                $delimiter = '/[\s]+/'; // فقط برای نوع 1
                $unitRemovals = [];
                break;
        
            case '2':
                $pattern = '/^(.+?)[\s\-:]+(.+)$/'; // برای نوع 2
                $unitRemovals = ['bar', 'meter', '%', 'm3/s'];
                break;
        
            default:
                $delimiter = '/[\s]+/'; // پیش‌فرض
                $unitRemovals = [];
                break;
        }
        
        // تقسیم پیام به خطوط
        $lines = explode("\n", trim($message));
        
        // آرایه برای ذخیره جفت‌های کلید-مقدار
        $messageArray = [];
        
        foreach ($lines as $line) {
            $line = trim($line); // حذف فاصله‌های اضافی
        
            if ($line === '') continue; // عبور از خطوط خالی
        
            if ($this->type == 2) {
                // استفاده از preg_match برای نوع 2
                if (preg_match($pattern, $line, $matches)) {
                    $key = trim($matches[1]);
                    $value = trim($matches[2]);
        
                    // حذف واحدهای اضافی از مقدار
                    foreach ($unitRemovals as $unit) {
                        $value = str_replace($unit, '', $value);
                    }
        
                    $messageArray[$key] = $value;
                }
            } else {
                // استفاده از preg_split برای سایر انواع
                $strtoarray = preg_split($delimiter, $line);
                if (count($strtoarray) >= 2) {
                    $key = trim($strtoarray[0]);
                    $value = trim($strtoarray[1]);
        
                    // حذف واحدها (در صورت وجود)
                    foreach ($unitRemovals as $unit) {
                        $value = str_replace($unit, '', $value);
                    }
        
                    $messageArray[$key] = $value;
                }
            }
        }
      
        return $messageArray;
        
           
    }
}
