<?php

namespace Database\Factories;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->department;
        return [
            'code' => $this->faker->unique()->numerify('######'),
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->paragraph,
        ];
    }
}
