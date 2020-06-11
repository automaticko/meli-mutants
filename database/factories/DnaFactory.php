<?php

/** @var Factory $factory */

use App\Models\Dna;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Dna::class, function (Faker $faker) {
    return [
        'sequence'  => [],
        'is_mutant' => $faker->boolean(),
    ];
});

