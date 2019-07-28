<?php

namespace App;

use App\Lists;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $guarded = [];

    public function list()
    {
        return $this->belongsTo(Lists::class);
    }
}
