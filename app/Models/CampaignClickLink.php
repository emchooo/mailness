<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignClickLink extends Model
{
    protected $fillable = ['campaign_id', 'link', 'contact_id'];
}
