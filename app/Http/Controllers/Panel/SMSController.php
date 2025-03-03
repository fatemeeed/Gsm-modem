<?php

namespace App\Http\Controllers\Panel;

use App\Models\Message;
use App\Models\Datalogger;
use Illuminate\Http\Request;
use App\Http\Requests\SMSRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\IndustrialCity;
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
        $messages = Message::where('type', '0')->orderBy('time', 'desc')->simplePaginate(15)->withQueryString();
        // $this->connect->send();
        return view('app.messages.index', compact('messages'));
    }

    public function recieveBox()
    {


        $messages = Message::where('type', '1')->orderBy('time', 'desc')->simplePaginate(15)->withQueryString();
        // $this->connect->send();

        return view('app.messages.index', compact('messages'));
    }

    public function createMessage()
    {
        if (auth()->user()->hasRole('SuperAdmin')) {

            $industrials = IndustrialCity::all();
        } else {

            $industrials = IndustrialCity::whereHas('users')->get();
        }


        return view('app.messages.create', compact('industrials'));
    }

    public function postMessage(SMSRequest $request, GSMConnection $gsmConnection)
    {
        $dataLogger = Datalogger::where('dataloggerable_id', $request->datalogger_id)->first();
        $mobile_number = $dataLogger->mobile_number;

        $response = DB::transaction(function () use ($mobile_number, $request, $gsmConnection, $dataLogger) {




            //$result=$gsmConnection->send($mobile_number, $request->content);

            try {
                $response = $gsmConnection->send($mobile_number, $request->content);
                

                if ($response) {

                    Message::create(
                        [
                            'from' => $mobile_number,
                            'datalogger_id' => $dataLogger->id,
                            'content' => $request->content,
                            'time' => Carbon::now(),
                            'type' => 0

                        ]
                    );

                    return 'success';
                }

                return 'error';
            } catch (\Exception $e) {
                Log::error('Failed to send SMS', ['error' => $e->getMessage()]);
                return response()->json(['error' => $e->getMessage()], 500);
            }
        });

        if ($response == 'success') {

            return redirect()->route('app.Message.send-box')->with('swal-success', 'پیام با موفقیت ارسال شد');
        }


        return redirect()->route('app.Message.send-box')->with('swal-error', 'پیام تایید دریافت نشد -خطا در ارسال پیام');


        // return redirect()->route('app.Message.send-box')->with('swal-success', 'پیام با موفقیت ارسال شد');
    }

    public function fetchIndustrial(Request $request)
    {

        $dataloggers = Datalogger::where("industrial_city_id", $request->industrial_id)->get();

        $data['dataloggers'] = $dataloggers->map(function ($datalogger) {
            if ($datalogger->dataloggerable) {
                return [
                    "name" => $datalogger->dataloggerable->name,
                    "id" => $datalogger->dataloggerable->id,
                ];
            }
            return [
                "name" => null,
                "id" => null,
            ];
        });


        return response()->json($data);
    }
}
