<?php

namespace App\Jobs;

use App\Models\Message;
use App\Models\Setting;
use App\Models\Datalogger;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Services\Message\GSMConnection;
use App\Http\Services\Message\RecieveMessageService;


class RecieveMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(GSMConnection $Connection): void
    {
       
			
		$arrMessages = $Connection->read();


 
        try {
            $Connection->deleteMessage(); // حذف پیام از مودم
        } catch (\Exception $e) {
            Log::error('خطا در حذف پیام از مودم', ['error' => $e->getMessage()]);
            // ادامه اجرای برنامه بدون توقف
        }

        $strJunk = array_shift($arrMessages);


        // set return array
        $arrReturn = array();



        // check that we have messages
        if (is_array($arrMessages) && !empty($arrMessages)) {
            // for each message
            foreach ($arrMessages as $arrMessage) {
                // split content from metta data
                $arrMessage    = explode("\n", $arrMessage, 2);
                $strMetta    = trim($arrMessage[0]);
                $arrMetta    = explode(",", $strMetta);

                // set the message array to go in the return array
                $arrReturnMessage = array();

                // set the message values to return
                $arrReturnMessage['Id']            = trim($arrMetta[0], "\"");
                $arrReturnMessage['Status']        = trim($arrMetta[1], "\"");
                $arrReturnMessage['From']        = str_replace('+98', '0', trim($arrMetta[2], "\""));
                $arrReturnMessage['Date']        = trim($arrMetta[4], "\"");
                $arrTime                        = explode("+", $arrMetta[5], 2);
                $arrReturnMessage['Time']        = trim($arrTime[0], "\"");

                // add message to return array
                $arrReturn[] = $arrReturnMessage;

                $datalogger = Datalogger::where('mobile_number', $arrReturnMessage['From'])->first();

                if ($datalogger) {

                    $strContent    = trim($arrMessage[1]);
                    $messageArray1 = [];


                    // dd($strContent);
                    $messageArray1 = $datalogger->parseMessage($strContent);

                    $lastStatus = $datalogger->last_status ?? [];



                    // بررسی و به‌روزرسانی وضعیت‌ها
                    foreach ($datalogger->checkCodes as $checkCode) {
                        if (isset($messageArray1[$checkCode->name]) && (!isset($lastStatus[$checkCode->name]) || $lastStatus[$checkCode->name] !== $messageArray1[$checkCode->name])) {
                            // فقط در صورتی که تغییر وجود داشته باشد، به‌روزرسانی می‌شود
                            $lastStatus[$checkCode->name] = $messageArray1[$checkCode->name];
                        }
                    }

                    if ($lastStatus) {
                        // به‌روزرسانی آخرین وضعیت و زمان آخرین به‌روزرسانی
                        $datalogger->lastCheckStatus = $lastStatus;

                        $datalogger->save();
                    }


                    Message::create([
                        'from'    => $datalogger->mobile_number,
                        'datalogger_id' => $datalogger->id,
                        'time'    => $arrReturnMessage['Date'] . ' ' . $arrReturnMessage['Time'],
                        'content' => $messageArray1,

                        'type'    => '1'
                    ]);
                }
            }
        }


    }
}
