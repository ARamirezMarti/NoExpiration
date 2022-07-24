<?php

namespace App\Services;

use App\Models\Alerts;
use Exception;
use Illuminate\Support\Carbon;

class Alertcreator{

    private $date;    
    private $alert1Day;
    private $alert2Day;
    private $alert1Week;
    

    public function createAlerts($date,$product_id){
        
        $this->date =Carbon::createFromFormat('Y-m-d', $date);        
        $this->create1DayAlert();
        $this->create2DayAlert();
        $this->createWeekAlert();
        
        try {
            Alerts::create([
                'product_id' => $product_id,
                'day_alert'  => $this->alert1Day,
                '2day_alert' => $this->alert2Day,
                'week_alert' => $this->alert1Week]);
                
        } catch (Exception $e) {
            throw new Exception('No se ha podido insertar las alertas');
            
        }
    }


    public function create1DayAlert(){        
        $this->alert1Day =$this->date->subDay();
    }

    public function create2DayAlert(){        
        $this->alert2Day = $this->date->subDays(2);        
    }
    public function createWeekAlert(){
        $this->alert1Week = $this->date->subWeek();        
    }

}