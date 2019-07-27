<?php

namespace App;

use App\Contact;
use Illuminate\Database\Eloquent\Model;

class Lists extends Model
{
    protected $guarded = [];

    public function contacts()
    {
    	return $this->belongsToMany(Contact::class);
    }
}
