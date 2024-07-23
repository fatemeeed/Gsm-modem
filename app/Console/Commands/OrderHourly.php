<?php

namespace App\Console\Commands;

use App\Jobs\OrderCodeHourly;
use Illuminate\Console\Command;

class OrderHourly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:orderHourly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'order code run hourly';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        OrderCodeHourly::dispatch();
    }
}
