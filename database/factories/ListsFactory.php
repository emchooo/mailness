<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Lists;
use Faker\Generator as Faker;

$factory->define(Lists::class, function (Faker $faker) {
    return [
        'name'	=> $faker->name,
        'uuid'  => $faker->uuid,
    ];
});
