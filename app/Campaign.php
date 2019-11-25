<?php

namespace App;

use Illuminate\Support\Str;
use App\Observers\CampaignObserver;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::observe(CampaignObserver::class);

        static::creating(function(Model $model){
            $model->uuid = Str::uuid();
        });
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

    public function links()
    {
        return $this->hasMany(CampaignLink::class);
    }

    public function opensTracking()
    {
        return $this->hasMany(CampaignOpen::class);
    }

    public function linksTracking()
    {
        return $this->hasMany(CampaignClickLink::class);
    }
}
