<?php

namespace App\Services;

use App\Models\Alerts;
use Exception;
use Illuminate\Support\Carbon;

class Alertcreator{

    public function __invoke($date,$product_id){
        
         $alert1Day = Carbon::createFromFormat('Y-m-d', $date)->subDay();
         $alert2Day = Carbon::createFromFormat('Y-m-d', $date)->subDays(2);
         $alert1Week = Carbon::createFromFormat('Y-m-d', $date)->subWeek();
        
     
        
        try {
            Alerts::create([
                'product_id' => $product_id,
                'day_alert'  => $alert1Day,
                '2day_alert' => $alert2Day,
                'week_alert' => $alert1Week]);
                
        } catch (Exception $e) {
            throw new Exception('No se ha podido insertar las alertas');
            
        }
    }


}