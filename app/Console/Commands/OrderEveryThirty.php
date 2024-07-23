<?php

namespace App\Console\Commands;

use App\Jobs\OrderCodeEveryThirtyMinute;
use Illuminate\Console\Command;

class OrderEveryThirty extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:orderEveryThirty';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'order code every thirty minutes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        OrderCodeEveryThirtyMinute::dispatch();
    }
}
