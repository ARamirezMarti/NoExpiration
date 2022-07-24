<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdType extends Model
{
    use HasFactory;
    protected $table = 'prod_type';

    public $timestamps = false;

    protected $fillable = [
        'type',
        'product_id',
        'user_id'
    ];
}
