<?php

namespace App\Console\Commands;

use App\Mail\ExpirationEmailQueue;
use App\Models\Alerts;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Jobs\ExpirationSendEmail;

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


        
      
        ExpirationSendEmail::dispatch();

    }
}
