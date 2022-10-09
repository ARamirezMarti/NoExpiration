<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;

class ExpeditionHandler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expedition:handle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the time until expedition time';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(LoggerInterface $loggerInterface)
    {
        Log::info("Cron : {$this->signature} has been launched. ");

        $products = DB::table('product')->get();
        
        foreach ($products as $prod) {
            $startTime = Carbon::parse($prod->buying_date);
            $finishTime = Carbon::parse($prod->expiration_date);            
            $days_left = $finishTime->diffInDays($startTime);

            try {
                DB::table('product')->where('id',$prod->id)->update(['days_left'=>$days_left]);                
            } catch (\Throwable $th) {                
                Log::Error("Cron Error : {$this->signature}. {$th->getMessage()} ");
            }
        }

        Log::info("Cron : {$this->signature} has been finished. ");
        
    }
}
