<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Company;
use App\Models\ProdType;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Alerts;
use App\Models\Inventory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        
        return [            
            'inventory_id'=>Inventory::first()->id,            
            'name' => $this->faker->name() ,
            'prod_type_id'=> rand(1,5),
            'buying_date' => now(),
            'expiration_date' => now(),
            'image' => $this->faker->text(150), 
        ];
    }
}
