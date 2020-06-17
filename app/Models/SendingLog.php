<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SendingLog extends Model
{
    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }
}
