<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Alerts>
 */
class AlertsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'product_id' => product::first(), // 'b'

            'day_alert' =>$this->faker->date(), // 'b'
            '2day_alert' => $this->faker->date(),
            'week_alert' => $this->faker->date(),
        ];
    }
}
