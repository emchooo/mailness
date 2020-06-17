<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Template;
use Faker\Generator as Faker;

$factory->define(Template::class, function (Faker $faker) {
    return [
        'name'  => $faker->name,
        'content'   => $faker->text,
        'type'      => 'editor',
    ];
});
