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
        $credentials = json_decode($value, true);
        if (isset($credentials['username'])) {
            $credentials['username'] = decrypt($credentials['username']);
        }
        if (isset($credentials['username'])) {
            $credentials['password'] = decrypt($credentials['password']);
        }
        if (isset($credentials['key'])) {
            $credentials['key'] = decrypt($credentials['key']);
        }
        if (isset($credentials['secret'])) {
            $credentials['secret'] = decrypt($credentials['secret']);
        }

        return $credentials;
    }

    // @todo refactor
    public function setCredentialsAttribute($value)
    {
        if (isset($value['username'])) {
            $value['username'] = encrypt($value['username']);
        }
        if (isset($value['password'])) {
            $value['password'] = encrypt($value['password']);
        }
        if (isset($value['key'])) {
            $value['key'] = encrypt($value['key']);
        }
        if (isset($value['secret'])) {
            $value['secret'] = encrypt($value['secret']);
        }
        $this->attributes['credentials'] = json_encode($value);

        return $this->credentials;
    }
}
