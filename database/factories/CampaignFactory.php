<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Campaign;
use Faker\Generator as Faker;

$factory->define(Campaign::class, function (Faker $faker) {
    return [
        'status'    => 'draft',
        'subject'   => $faker->name,
        'sending_name'  => $faker->name,
        'sending_email' => $faker->email,
        'content'   => $faker->text,
    ];
});

$factory->state(Campaign::class, 'sent', [
    'status' => 'sent',
]);
