<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alerts extends Model
{
    use HasFactory;
    public $timestamps = false;


    protected $fillable = [
        'product_id',
        'day_alert',
        '2day_alert',
        'week_alert',
    ];

   

}