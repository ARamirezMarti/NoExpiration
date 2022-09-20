<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'product';

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'inventory_id',
        'prod_type_id',
        'name',
        'buying_date',
        'expiration_date',
        'image',
        'days_left'
    ];

    public static function getProductsByInventoryID($id){
        return self::query()->where('inventory_id', '=', $id)->get();

    }
    public static function getCountProductsByInventoryID($id){
        return self::query()->where('inventory_id', '=', $id)->count();

    }

}
