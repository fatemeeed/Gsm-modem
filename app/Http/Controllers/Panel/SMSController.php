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
        $tel = Datalogger::where('id', $request->datalogger_id)->first();

        DB::transaction(function () use ($tel,$request) {

            $message = new SendMessageService();
            $result = $message->send($tel, $request->content);

            $newMessage=Message::create(
                [
                    'from' => $tel,
                    'datalogger_id' => $request->datalogger_id,
                    'content' => $request->content,
                    'type' => 0
                ]
            );

            if ($newMessage) {
                return redirect()->route('app.Message.send-box')->with('swal-success', 'پیام  با موفقیت ارسال شد');
            }
        });



        
    }
}
