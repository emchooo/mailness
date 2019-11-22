<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignLink extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['link', 'uuid'];
}
