<?php

namespace App\Jobs;

use App\Mail\ExpirationEmailQueue;
use App\Models\Alerts;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
            Log::info("Email Job for {$time}: Found {$cantidad}");

            foreach ($alerts->toArray() as $item) {
                try {
                    Mail::to('antonio.ramirez.marti@gmail.com')->send(new ExpirationEmailQueue(
                        $item["productName"],
                        $item["username"],
                        $item["expiration_date"],
                        $item["inventoryName"])); 
                } catch (\Throwable $th) {
                    Log::error("Fallo en el envio de email {$th->getMessage()}");
                }
            }
        }
    }
}
