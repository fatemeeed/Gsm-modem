<?php

namespace App\Console\Commands;

use App\Jobs\OrderCodeEveryTenMinutes;
use Illuminate\Console\Command;

class OrderEveryTen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:orderEveryTen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'order code every ten minutes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        OrderCodeEveryTenMinutes::dispatch();
    }
}
