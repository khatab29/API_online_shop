<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'title' => $faker->word(),
        'supplier_id' => rand(1, 10),
        'category_id' => rand(1, 10),
        'price' => $faker->numberBetween($min = 50, $max = 250),
        'discount' => $faker->numberBetween($min = 5, $max = 45),
        'final_price' => $faker->numberBetween($min = 40, $max = 250),
        'quantity' => 20,
    ];
});
