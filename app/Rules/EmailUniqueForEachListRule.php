<?php

namespace App\Rules;

use App\Contact;
use App\Lists;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;

class EmailUniqueForEachListRule implements Rule
{
    /** @var \App\Lists|null */
    private $list;

    /** @var \App\Contact|null */
    private $contact;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(?Lists $list = null, ?Contact $contact = null)
    {
        $this->list = $list;
        $this->contact = $contact;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $contact = $this->contact;
        $lits = $this->contact;

        return null === Contact::query()
                                ->where('email', $value)
                                ->when($this->list, function (Builder $query) use ($contact) {
                                    return $query->where('list_id', '=', $this->list->id);
                                })
                                ->when($contact, function (Builder $query) use ($contact) {
                                    return $query->where('id', '!=', $contact->id);
                                })
                                ->first();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute has already registered to list.';
    }
}
