<?php

use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
        'sifra_inventara' => $faker->text(50),
        'naziv_inventara' => $faker->text(50),
        'slika_inventara' => $faker->text(50),
        'datum_nabave' => $faker->text(50),
        'godina_nabave' => $faker->text(50),
        'nabavna_vrijednost' => $faker->text(50),
        'stopa_amortizacije' => $faker->text(50),
        'kolicina' => $faker->text(50),
        'jedinica_mjere' => $faker->text(50),
        'napomena' => $faker->text(50),
        'ulazna_faktura' => $faker->text(50),
        'otpis_inventara' => $faker->text(200),
    ];
});
