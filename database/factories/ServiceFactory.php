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
            'username'	=> '2301530d2ee47a',
            'password'	=> 'ce4afe331cef83',
            'host' => 'smtp.mailtrap.io',
            'port' => 2525,
            'transport' => 'smtp',
            'encription' => null,
        ],
    ];
});
