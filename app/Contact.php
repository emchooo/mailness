<?php

namespace App;

use App\Lists;
use App\ContactField;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $guarded = [];

    public function list()
    {
        return $this->belongsTo(Lists::class);
    }

    public function fields()
    {
        return $this->belongsToMany(Field::class)->withPivot('value');
    }
}
