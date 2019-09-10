<?php

namespace App;

use App\Contact;
use App\Field;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Lists extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($list) {
            $list->uuid = (string) Str::uuid();
        });
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'list_id')->active();
    }

    public function fields()
    {
        return $this->hasMany(Field::class, 'list_id');
    }
}
