<?php

namespace App\Console\Commands;

use App\Http\Services\Message\RecieveMessageService;
use App\Jobs\ConnectModem;
use App\Jobs\RecieveMessage as JobsRecieveMessage;
use App\Models\Message;
use App\Models\Setting;
use Illuminate\Console\Command;

class RecieveMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:recieveMessage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    public $connect;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        

        JobsRecieveMessage::dispatch();
        
    }
}
