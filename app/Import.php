<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    protected $fillable = ['list_id', 'path', 'contacts_subscribed', 'skip_duplicate'];

    public function list()
    {
        return $this->belongsTo(Lists::class);
    }
}
