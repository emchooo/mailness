<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Field;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Field::class, function (Faker $faker) {
    $name = $faker->name;

    return [
        'name'	=> $name,
        'slug' => Str::slug($name),
    ];
});
