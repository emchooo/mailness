<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $casts = [
        'credentials' => 'array',
    ];

    public function getSecretAttribute($value)
    {
        return substr_replace($value, '***************', 0, 35);
    }
}
