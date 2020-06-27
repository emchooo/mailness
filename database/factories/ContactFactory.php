<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Contact;
use Faker\Generator as Faker;

$factory->define(Contact::class, function (Faker $faker) {
    return [
        'email'	=> $faker->unique()->safeEmail,
    ];
});
