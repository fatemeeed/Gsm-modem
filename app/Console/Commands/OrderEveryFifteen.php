<?php

namespace App\Console\Commands;

use App\Jobs\OrderCodeEveryFifteenMinutes;
use Illuminate\Console\Command;

class OrderEveryFifteen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:orderEveryFifteen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'order code every fifteen minutes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        OrderCodeEveryFifteenMinutes::dispatch();
    }
}
