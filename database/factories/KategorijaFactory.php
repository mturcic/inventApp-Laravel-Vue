<?php

use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
        'naziv_kategorije' => $faker->text(255)
    ];
});
