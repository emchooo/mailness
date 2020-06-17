<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Lists extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'uuid', 'double_opt_in', 'from_name', 'from_email'];

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

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class, 'list_id')->subscribed();
    }

    public function unsubscribedContacts(): HasMany
    {
        return $this->hasMany(Contact::class, 'list_id')->unsubscribed();
    }

    public function fields(): HasMany
    {
        return $this->hasMany(Field::class, 'list_id');
    }

    public function bounces()
    {
        return $this->contacts()->bounces();
    }

    public function complaints()
    {
        return $this->contacts()->complaints();
    }

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 10;
}
