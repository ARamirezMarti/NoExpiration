<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Alerts;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ExpirationEmailQueue;

class ExpirationSendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $times = ['week','2day','day'];

        
        foreach ($times as $time) {
            $alerts = Alerts::getProductsExpirationAlerts($time);

            $cantidad = count($alerts);
            Log::emergency("Email Job for {$time}: Found {$cantidad}");
            foreach ($alerts as $item) {
                try {
                    Mail::to('antonio.ramirez.marti@gmail.com')->send(new ExpirationEmailQueue(
                        $item->productName,
                        $item->username,
                        $item->expiration_date,
                        $item->inventoryName)); 
                } catch (\Throwable $th) {
                    Log::error("Fallo en el envio de email {$th->getMessage()}");
                }
            }
        }
    }
}