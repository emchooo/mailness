<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function getSecretAttribute($value)
    {
        return substr_replace($value, '***************', 0, 35);
    }
}
