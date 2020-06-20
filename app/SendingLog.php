<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SendingLog extends Model
{
    protected $fillable = ['contact_id', 'campaign_id', 'sent_at', 'opened_at', 'bounced_at', 'complaint_at'];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function opened()
    {
        $this->update([
            'opened_at' => now()
        ]);
    }

    public function bounced()
    {
        $this->update([
            'bounced_at' => now()
        ]);
    }

    public function complaint()
    {
        $this->update([
            'complaint_at' => now()
        ]);
    }
}
