<?php

use Faker\Generator as Faker;

$factory->define(AutoKit\Product::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(rand(3, 6), true),
        'price' => $faker->randomFloat(2, 0, 10000),
        'old_price' => rand(1, 5) > 3 ? $faker->randomFloat(2, 0, 10000) : null,
        'quantity' => $faker->numberBetween(0, 15),
        'is_top' => rand(1, 4) > 3 ? 1 : 0,
        'is_new' => rand(1, 4) > 3 ? 1 : 0,
        'img' => 'http://via.placeholder.com/800x500?text=Product+image',
        'description' => $faker->text(rand(50, 300)),
        'category_id' => $faker->numberBetween(1, 21),
        'brand_id' => $faker->numberBetween(1, 8)
    ];
});
