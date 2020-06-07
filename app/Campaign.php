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
    const FINISHED = 'finished';

    /**
     * Checks if Current Campaign status is as Specified.
     *
     * @param string $status
     * @return bool
     **/
    public function isInStatus(string $status): bool
    {
        if ($this->status === $status) {
            return true;
        }

        return false;
    }

    /**
     * Checks if Current Campaign status is Draft.
     *
     * @return bool
     **/
    public function isDraft()
    {
        return $this->isInStatus($this::DRAFT);
    }

    /**
     * Checks if Current Campaign status is Not Draft.
     *
     * @return bool
     **/
    public function isNotDraft()
    {
        return ! $this->isDraft();
    }

    /**
     * Checks if Current Campaign status is Finished.
     *
     * @return bool
     **/
    public function isFinished()
    {
        return $this->isInStatus($this::FINISHED);
    }

    /**
     * Checks if Current Campaign status is Not FINISHED.
     *
     * @return bool
     **/
    public function isNotFinished()
    {
        return ! $this->isFinished();
    }

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

    public function setTotalSentTo($number_sent)
    {
        $this->total_sent = $this->total_sent + $number_sent;
        $this->save();
    }

    public function totalSent()
    {
        return $this->hasMany(SendingLog::class)->whereNotNull('sent_at');
    }

    public function setAsSent()
    {
        $this->status = 'sent';
        $this->save();
    }
}
