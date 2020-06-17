<?php

namespace App\Jobs;

use App\Models\Contact;
use App\Models\Field;
use App\Models\Import;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportContacts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $contacts;

    protected $list_id;

    protected $import_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $contacts, $list_id, $import_id)
    {
        $this->contacts = $contacts;
        $this->list_id = $list_id;
        $this->import_id = $import_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $import = Import::findOrFail($this->import_id);
        foreach ($this->contacts as $contact) {
            $this->import_contact($contact, $this->list_id, $import);
        }
    }

    public function import_contact(array $contact_array, $list_id, $import)
    {
        $contact = Contact::where('email', $contact_array['email'])->where('list_id', $list_id)->first();
        if ($contact and $import->skip_duplicate) {
            return;
        }
        if ($contact) {
            $this->update_contact($contact_array, $contact, $import);

            return;
        } else {
            $this->new_contact($contact_array, $list_id, $import);
        }
    }

    public function update_contact($contact_array, $contact, $import)
    {
        $contact->subscribed = $import->contacts_subscribed;
        $contact->save();

        $contact->fields()->detach();
        $fields = $contact_array;
        unset($fields['email']);
        foreach ($fields as $key => $value) {
            if ($value) {
                $field = Field::where('slug', $key)->where('list_id', $contact->list_id)->first();
                $contact->fields()->attach($field, ['value' => $value]);
            }
        }
    }

    public function new_contact($contact_array, $list_id, $import)
    {
        if (filter_var($contact_array['email'], FILTER_VALIDATE_EMAIL)) {
            $contact = new Contact();
            $contact->list_id = $list_id;
            $contact->email = $contact_array['email'];
            $contact->subscribed = $import->contacts_subscribed;
            $contact->save();

            $fields = $contact_array;
            unset($fields['email']);
            foreach ($fields as $key => $value) {
                if ($value) {
                    $field = Field::where('slug', $key)->where('list_id', $list_id)->first();
                    $contact->fields()->attach($field, ['value' => $value]);
                }
            }
        }
    }
}
