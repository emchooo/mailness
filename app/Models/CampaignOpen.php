<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignOpen extends Model
{
    protected $fillable = ['campaign_id', 'contact_id'];

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }
}
