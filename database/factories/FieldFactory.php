<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Field;
use Faker\Generator as Faker;

$factory->define(Field::class, function (Faker $faker) {
    return [
        'name'	=> $faker->name
    ];
});
