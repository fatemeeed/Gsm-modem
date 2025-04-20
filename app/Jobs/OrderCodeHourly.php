<?php

namespace App\Jobs;

use App\Http\Services\Message\GSMConnection;
use Carbon\Carbon;
use App\Models\Datalogger;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class OrderCodeHourly implements ShouldQueue
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
    public function handle(): void
    {

        $gsmConnection = app(GSMConnection::class);
        $now = Carbon::now();
        $dataloggers = Datalogger::whereHas('order_codes', function ($query) use ($now) {

            $query->where('datalogger_order_code.time', '60')->where('datalogger_order_code.last_sent_at', '<=', $now->subMinutes(60))->orWhereNull('datalogger_order_code.last_sent_at')->where('status','1');
        })->get();

        foreach ($dataloggers as $datalogger) {
            foreach ($datalogger->order_codes as $order_code) {

                $gsmConnection->send($datalogger->mobile_number,$order_code->name);

                // Update the pivot table last_sent_at to current time after processing
                $datalogger->order_codes()->updateExistingPivot($order_code->id, ['last_sent_at' => $now]);
            }
        }
    }
}
