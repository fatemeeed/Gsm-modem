<?php

namespace App\Http\Controllers\Panel;

use App\Models\Message;
use App\Models\Setting;
use App\Models\Datalogger;
use Illuminate\Http\Request;
use App\Http\Requests\SMSRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Http\Services\Message\GSMConnection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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

    public function postMessage(SMSRequest $request, GSMConnection $gsmConnection)
    {
        $dataLogger = Datalogger::where('id', $request->datalogger_id)->first();
        $mobile_number = $dataLogger->mobile_number;

        DB::transaction(function () use ($mobile_number, $request, $gsmConnection) {


            //$result=$gsmConnection->send($mobile_number, $request->content);

            try {
                $response = $gsmConnection->send($mobile_number, $request->content);

                Message::create(
                    [
                        'from' => $mobile_number,
                        'datalogger_id' => $request->datalogger_id,
                        'content' => $request->content,
                        'time' => Carbon::now(),
                        'type' => 0

                    ]
                );


                Log::info('SMS sent', ['phone_number' => $mobile_number, 'message' => $request->content, 'response' => $response]);
                return response()->json(['response' => $response]);
            } catch (\Exception $e) {
                Log::error('Failed to send SMS', ['error' => $e->getMessage()]);
                return response()->json(['error' => $e->getMessage()], 500);
            }
        });
        return redirect()->route('app.Message.send-box')->with('swal-success', 'پیام  با موفقیت ارسال شد');
    }
}
