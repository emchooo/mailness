<?php

namespace App\Jobs;

use App\Field;
use App\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ImportContact implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $contact;

    protected $header;

    protected $list;

    protected $import;

    protected $custom_fields;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($contact, $header, $list, $import, $custom_fields)
    {
        $this->contact = $contact;
        $this->header = $header;
        $this->list = $list;
        $this->import = $import;
        $this->custom_fields = $custom_fields;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->contact[0]) {
            $row = array_combine($this->header, $this->contact);

            $checkContact = Contact::where('email', $row[$this->custom_fields['email']])->where('list_id', $this->list->id)->first();

            if ($checkContact and $this->import->skip_duplicate) {
                return;
            }

            if ($checkContact) {
                $checkContact->subscribed = $this->import->contacts_subscribed;
                $checkContact->save();

                $checkContact->fields()->detach();
                foreach ($this->custom_fields as $key => $value) {
                    if ($value) {
                        $field = Field::where('name', $key)->first();
                        $checkContact->fields()->attach($field, ['value' => $row[$value]]);
                    }
                }
            } else {
                $email = $row[$this->custom_fields['email']];

                if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $contact = new Contact();
                    $contact->list_id = $this->list->id;
                    $contact->email = $email;
                    $contact->subscribed = $this->import->contacts_subscribed;
                    $contact->save();

                    foreach ($this->custom_fields as $key => $value) {
                        if ($value) {
                            $field = Field::where('name', $key)->first();
                            $contact->fields()->attach($field, ['value' => $row[$value]]);
                        }
                    }
                }
            }
        }
    }
}
