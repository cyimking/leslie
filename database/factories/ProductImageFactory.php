<?php

use Faker\Generator as Faker;
use Leslie\Product;

$factory->define(\Leslie\ProductImage::class, function (Faker $faker) {

    $products = Product::all()->pluck('id');

    return [
        'path' => $faker->imageUrl(),
        'product_id' => $faker->randomElement($products->all())
    ];
});
