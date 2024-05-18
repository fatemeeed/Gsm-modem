<?php

namespace App\Http\Controllers\Panel;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Interfaces\MessageInterface;
use App\Http\Services\Message\Connect\ConnectService;
use App\Models\Datalogger;
use App\Models\Message;

class SMSController extends Controller
{
    // public $connect;
    
    // public function __construct(MessageInterface $connect)
    // {

    //     $setting=Setting::all();
    //     $setting=new ConnectService(true,$setting->port,$setting->baud);
    //     $this->connect=$connect;
        
    //     $this->connect->init();
        
    // }
    public function sendBox()
    {
        $messages=Message::where('type','0')->simplePaginate(15)->withQueryString();
        // $this->connect->send();
        return view('app.messages.index',compact('messages'));
        
    }

    public function recieveBox()
    {


        $messages=Message::where('type','1')->simplePaginate(15)->withQueryString();
        // $this->connect->send();
        return view('app.messages.index',compact('messages'));
    }

    public function createMessage()
    {
  
        $dataLoggers=Datalogger::all();
        return view('app.messages.create',compact('dataLoggers'));

    }
}
