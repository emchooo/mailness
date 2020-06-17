<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactField extends Model
{
    public function field(): BelongsTo
    {
        return $this->belongsTo(Field::class);
    }
}
