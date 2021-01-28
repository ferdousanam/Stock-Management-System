<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->productName;
        return [
            'product_code' => $this->faker->unique()->numerify('######'),
            'title' => $title,
            'product_category_id' => ProductCategory::inRandomOrder()->first()->id,
            'product_brand_id' => ProductBrand::inRandomOrder()->first()->id,
            'price' => $this->faker->numberBetween(50, 10000),
            'alert_quantity' => $this->faker->numberBetween(0, 20),
            'slug' => Str::slug($title),
        ];
    }
}
