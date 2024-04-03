<?php

namespace App\Jobs;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
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
    public function handle(): void
    {
        $setting=Setting::all();
        $recieve=new RecieveMessageService();
        $recieve->setPort($setting->port);
        $recieve->setBaud($setting->baud);
        $recieve->setDebug('true');

        $recieve->init();
        $result[]=$recieve->read();


    }
}
