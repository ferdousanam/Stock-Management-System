<?php

namespace Database\Factories;

use App\Models\Purchase;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Purchase::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
//            'purchase_code' => $this->faker->unique()->numerify('##########'),
            'net_total' => $this->faker->numberBetween(50, 10000),
            'net_discount' => $this->faker->numberBetween(0, 100),
            'payment_status' => $this->faker->randomElement(['pending', 'paid']),
            'warehouse_id' => Warehouse::inRandomOrder()->first()->id,
        ];
    }
}
