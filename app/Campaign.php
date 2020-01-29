<?php

namespace App;

use App\Observers\CampaignObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campaign extends Model
{
    const DRAFT = 'draft';
    const SENDING = 'sending';
    const SENT = 'sent';

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::observe(CampaignObserver::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['status', 'subject', 'sending_name', 'sending_email', 'preview_text', 'content', 'track_opens', 'track_clicks'];

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 10;

    public function links(): HasMany
    {
        return $this->hasMany(CampaignLink::class);
    }

    public function opensTracking(): HasMany
    {
        return $this->hasMany(CampaignOpen::class);
    }

    public function linksTracking(): HasMany
    {
        return $this->hasMany(CampaignClickLink::class);
    }
}
