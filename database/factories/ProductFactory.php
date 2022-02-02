<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sku' => $this->faker->unique()->ean8(),
            'name' => $this->faker->bothify('?????? ?????'),
            'category' => $this->faker->bothify('?????'),
            'price' => $this->faker->numberBetween(1000, 1000000),
        ];
    }
}
