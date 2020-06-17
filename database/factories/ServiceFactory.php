<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Service;
use Faker\Generator as Faker;

$factory->define(Service::class, function (Faker $faker) {
    return [
        'service' => 'log',
        'credentials' => [
            'from' => [
                'name' => 'Emir Factory',
                'address' => 'test@factory.com',
            ],
            'username'	=> 'test',
            'password'	=> 'test',
            'host' => 'smtp.test.com',
            'port' => 2525,
            'transport' => 'log',
            'encription' => null,
        ],
    ];
});
