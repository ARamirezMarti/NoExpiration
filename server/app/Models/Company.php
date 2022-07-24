<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $table = 'company';

    public $timestamps = false;


    protected $fillable = [
        'product_id',
        'user_id',
        'name',
        'location',
        
    ];
}
