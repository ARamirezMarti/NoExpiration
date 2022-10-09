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


    public static function getProductsExpirationAlerts($time)
    {
        $selection  = '
        CONCAT(users.name," ",users.lastname) as username,
        product.expiration_date,
        product.name as productName,
        inventory.name as inventoryName
        ';

        $curdate = date("Y-n-d");        

        $alerts = self::selectRaw($selection)->where($time.'_alert','=', $curdate)
        ->join('product', 'product.id', '=', 'alerts.product_id')
        ->join('inventory', 'inventory.id', '=', 'product.inventory_id')
        ->join('users', 'users.id', '=', 'inventory.user_id')
        ->get();
        return $alerts;
    }   

}