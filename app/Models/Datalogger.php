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
        return $this->messages()->where('type','1')->latest('time')->first();
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

        $currentHeight =$this->lastRecieveMessage()->content['Height'];
       
        $baseHeight = $this->fount_height;
        
        $persent =(($currentHeight / $baseHeight) * 100);

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


    public function parseMessage($message)
    {
        // Set delimiter and unit removal array based on type
        switch ($this->type) {
            case '1':
                $delimiter = "/[\s]+/"; // Split by any whitespace for type 1
                $unitRemovals = [];      // No units to remove for type 1
                break;

            case '2':
                $delimiter = "/\s*:\s*/"; // Split by colon for type 2
                $unitRemovals = ['m3/s', 'meter', '%','bar']; // Units to remove in type 2
                break;

            default:
                // Default to a safe delimiter if type is unrecognized
                $delimiter = "/[\s]+/";
                $unitRemovals = [];
                break;
        }

        // Break message into lines
        $lines = explode("\n", trim($message));

        // Initialize an array to store parsed key-value pairs
        $messageArray = [];
        foreach ($lines as $line) {
            // Split line based on the chosen delimiter
            $strtoarray = preg_split($delimiter, $line);

            // Ensure we have exactly two parts
            if (count($strtoarray) == 2) {
                $key = trim($strtoarray[0]);    // Extract key
                $value = trim($strtoarray[1]);  // Extract value

                // Remove any unwanted units from the value
                foreach ($unitRemovals as $unit) {
                    $value = str_replace($unit, '', $value);
                }

                // Store the cleaned key-value pair
                $messageArray[$key] = $value;
            }
        }

        return $messageArray;
    }
}
