<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            Product::PRODUCT_ARTICLE => 'article-' . rand(1, 10000),
            Product::PRODUCT_DATA => [
               0 => [
                   'size' => rand(10, 50),
                   'color' => 'blue'
               ],
                1 => [
                    'size' => rand(10, 50),
                    'color' => 'red'
                ],
                2 => [
                    'size' => rand(10, 50),
                    'color' => 'black'
                ]
            ],
            Product::PRODUCT_NAME => $this->faker->name,
            Product::PRODUCT_STATUS => Product::PRODUCT_STATUS_AVAILABLE,
        ];
    }
}
