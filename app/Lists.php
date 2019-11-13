<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Lists extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'uuid', 'double_opt_in'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
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

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 10;
}
