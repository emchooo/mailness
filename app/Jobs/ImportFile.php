<?php

namespace App\Jobs;

use App\Import;
use App\Services\ImportContacts;
use App\Contact;
use App\Field;
use App\Lists;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ImportFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $import;

    protected $custom_fields;

    protected $list;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($custom_fields, Lists $lists, $import_id)
    {
        $this->import = Import::findOrFail($import_id);
        $this->custom_fields = $custom_fields;
        $this->list = $lists;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $importer = new ImportContacts($this->import->id);

        $file = $importer->getFile();
        $headers = $importer->getHeaders();

        while (!$file->eof()) {

            $single = $file->fgetcsv();

            if ($single[0]) {
                $row = array_combine($headers, $single);

                $checkContact = Contact::where('email', $row[$this->custom_fields['email']])->where('list_id', $this->list->id)->first();

                if ($checkContact and $this->import->skip_duplicate) {
                    continue;
                }

                if ($checkContact) {
                    $checkContact->subscribed = $this->import->contacts_subscribed;
                    $checkContact->save();

                    $checkContact->fields()->detach();
                    foreach ($this->custom_fields as $key => $value) {
                        // @todo: use ID here
                        echo 'Key: '.$key.' Value: '.$value.'<br>';
                        if ($value) {
                            $field = Field::where('name', $key)->first();
                            $checkContact->fields()->attach($field, ['value' => $row[$value]]);
                        }
                    }
                } else {
                    // for test now, later add as job
                    $contact = new Contact();
                    $contact->list_id = $this->list->id;
                    $contact->email = $row[$this->custom_fields['email']];
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
