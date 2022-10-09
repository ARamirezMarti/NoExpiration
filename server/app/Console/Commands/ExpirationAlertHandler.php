<?php

namespace App\Console\Commands;

use App\Jobs\ExpirationSendEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
class ExpirationAlertHandler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expirationalert:handle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Call the Job ExpirationSendEmail to check the alerts and create a queue of Emails to sent';


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        
        Log::info("Cron : {$this->signature} has been launched. ");

        ExpirationSendEmail::dispatch();

    }
}
