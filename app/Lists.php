<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Lists extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'uuid', 'double_opt_in'];

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($list) {
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
