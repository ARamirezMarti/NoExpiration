<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $table = 'inventory';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'name',
        'description'
    ];
    

    public static function getInventoriesByUserId($user_id){
        return self::query()->where('user_id', '=', $user_id)->get();
    }
    
    public static function deleteInventory($user_id,$inventory_id){
        return self::query()
        ->where('id', '=', $inventory_id)
        ->where('user_id', '=', $user_id)
        ->delete();
    }
    
}
