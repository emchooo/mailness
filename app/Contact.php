<?php

namespace App;

use App\Lists;
use App\ContactField;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email','list_id','subscribed','unsubscribed_at','bounced_at','complaint_at'];

    public function list()
    {
        return $this->belongsTo(Lists::class);
    }

    public function fields()
    {
        return $this->belongsToMany(Field::class)->withPivot('value');
    }

    public function getFieldValue($field_id)
    {
        if($this->fields()->where('field_id', $field_id)->first()) {
            return $this->fields()->where('field_id', $field_id)->first()->pivot->value;
        }
    }

    public function scopeActive($query)
    {
        return $query->where('subscribed', 1);
    }

    public function scopeInactive($query)
    {
        return $query->where('subscribed', 0);
    }
    
}
