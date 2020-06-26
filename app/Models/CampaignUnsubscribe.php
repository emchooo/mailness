<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignUnsubscribe extends Model
{
    protected $fillable = ['campaign_id', 'contact_id'];
}
