<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignClickLink extends Model
{
    protected $fillable = ['campaign_id', 'link_id', 'contact_id'];
}
