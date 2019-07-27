<?php

namespace App;

use App\Lists;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $guarded = [];

    public function lists()
    {
        return $this->belongsToMany(Lists::class);
    }
}
