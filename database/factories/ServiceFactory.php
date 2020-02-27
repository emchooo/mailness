<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Service;
use Faker\Generator as Faker;

$factory->define(Service::class, function (Faker $faker) {
    return [
        'service' => 'smtp',
        'credentials' => [
            'username'	=> 'test',
            'password'	=> 'test',
        ],
    ];
});
