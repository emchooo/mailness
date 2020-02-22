<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $casts = [
        'credentials' => 'array',
    ];

    public function getConfig()
    {
    	return $this->credentials;
    }

    public function getCredentialsAttribute($value) 
    {
<<<<<<< HEAD
        $credentials = json_decode($value, true);
        $credentials['username'] = decrypt($credentials['username']);
        $credentials['password'] = decrypt($credentials['password']);
        return $credentials;
    }

    public function setCredentialsAttribute($value)
    {
        $value['username'] = encrypt($value['username']);
        $value['password'] = encrypt($value['password']);
        $this->attributes['credentials'] = json_encode($value);
=======
        return $this->credentials;
>>>>>>> 26fdfa98e34bcd774e123442bf315d887874db1b
    }
}
