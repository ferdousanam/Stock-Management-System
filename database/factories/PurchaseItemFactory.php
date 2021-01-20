<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PurchaseItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $unit_cost = $this->faker->numberBetween(50, 2000);
        $quantity = $this->faker->numberBetween(1, 100);
        $net_discount = $unit_cost * $quantity * 0.1;
        $net_cost = $unit_cost * $quantity - $net_discount;
        return [
            'purchase_id' => Purchase::inRandomOrder()->first()->id,
            'product_id' => Product::inRandomOrder()->first()->id,
            'unit_cost' => $unit_cost,
            'net_cost' => $net_cost,
            'net_discount' => $net_discount,
            'quantity' => $quantity,
            'status' => $this->faker->randomElement(['pending', 'received']),
        ];
    }
}
