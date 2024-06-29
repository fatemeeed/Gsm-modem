<?php

namespace App\Http\Controllers\Panel;

use App\Models\Message;
use App\Models\Setting;
use App\Models\Datalogger;
use Illuminate\Http\Request;
use App\Http\Requests\SMSRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Interfaces\MessageInterface;
use App\Http\Services\Message\SendMessageService;
use App\Http\Services\Message\Connect\ConnectService;

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
        $messages = Message::where('type', '0')->simplePaginate(15)->withQueryString();
        // $this->connect->send();
        return view('app.messages.index', compact('messages'));
    }

    public function recieveBox()
    {


        $messages = Message::where('type', '1')->simplePaginate(15)->withQueryString();
        // $this->connect->send();
        return view('app.messages.index', compact('messages'));
    }

    public function createMessage()
    {

        $dataLoggers = Datalogger::all();
        return view('app.messages.create', compact('dataLoggers'));
    }

    public function postMessage(SMSRequest $request)
    {
        $dataLogger = Datalogger::where('id', $request->datalogger_id)->first();
        $mobile_number = $dataLogger->mobile_number;

        DB::transaction(function () use ($mobile_number, $request) {

            $config = Setting::first();
            $sendMessage = new SendMessageService();
            $sendMessage->setDebug('false');
            $sendMessage->setPort($config->port);
            $sendMessage->setBaud($config->baud_rate);

            $sendMessage->init();
            $result = $sendMessage->send($mobile_number, $request->content);
         

            if ($result) {
                 Message::create(
                    [
                        'from' => $mobile_number,
                        'datalogger_id' => $request->datalogger_id,
                        'content' => $request->content,
                        'type' => 0

                    ]
                );

               
                    return redirect()->route('app.Message.send-box')->with('swal-success', 'پیام  با موفقیت ارسال شد');
               
            }
        });
    }
}
