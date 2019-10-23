<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactField extends Model
{
    public function field()
    {
        return $this->belongsTo(Field::class);
    }
}
