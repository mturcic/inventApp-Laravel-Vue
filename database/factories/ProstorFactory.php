<?php

use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
        'opis_prostora' => $faker->text(255),
        'adresa_prostora' => $faker->text(255)
    ];
});
