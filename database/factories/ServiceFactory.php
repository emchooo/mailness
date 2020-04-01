<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Service;
use Faker\Generator as Faker;

$factory->define(Service::class, function (Faker $faker) {
    return [
        'service' => 'smtp',
        'credentials' => [
            'from' => [
                'name' => 'Emir',
                'address' => 'test@gmail.com',
            ],
            'username'	=> '',
            'password'	=> '',
            'host' => 'smtp.test.com',
            'port' => 2525,
            'transport' => 'smtp',
            'encription' => null,
        ],
    ];
});
