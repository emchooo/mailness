<?php

namespace App\Services;

use App\Contact;
use App\Import;

class ImportContacts
{
    protected $file;

    public function setFile($request, $lists, $import)
    {
        $file_path = storage_path( 'app/public/' . $import->path);
        
        $this->file = new \SplFileObject($file_path, 'r');
        $this->file->setFlags(\SplFileObject::READ_CSV);

        return $this;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function getHeaders()
    {
        $headers = $this->file->current();
        return $headers;
    }

    public function isEmailFieldsValidEmailAddress($request)
    {
        $headers = $this->file->current();

        $this->file->seek(1);

        $first_line = array_combine($headers, $this->file->current());

        $first_line_email = $first_line[$request['email']];

        $this->file->rewind();
        $this->file->current();

        if(!filter_var($first_line_email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

    public function getFileFields($file_id)
    {
        $file = Import::findOrFail($file_id);

        $file_path = storage_path( 'app/public/' . $file->path);

        $file = new \SplFileObject($file_path, 'r');
        $file->setFlags(\SplFileObject::READ_CSV);
        
        return $file->current();
    }

    public function getListFields($lists)
    {
        return $lists->fields->pluck('name');
    }

    public function import($file, $headers)
    {
        while (!$file->eof()) {
            $single = $file->fgetcsv();

            if($single[0]) {
                $row = array_combine($headers, $single);

                $checkContact = Contact::where('email', $row[$request['email']])->where('list_id', $lists->id)->first();

                if($checkContact and $import->skip_duplicate) { continue; } 

                if($checkContact) {
                    $checkContact->subscribed = $import->contacts_subscribed;
                    $checkContact->save();

                    $checkContact->fields()->detach();
                    foreach($custom_fields as $key => $value) {
                        // @todo: use ID here
                        echo "Key: " . $key . ' Value: ' . $value . '<br>';
                    if($value) {
                            $field = Field::where('name', $key)->first();
                            $checkContact->fields()->attach($field, [ 'value' => $row[$value] ]);
                    } 
                    }
                } else {
                    // for test now, later add as job
                    $contact = new Contact();
                    $contact->list_id = $lists->id;
                    // is $row[$request['email']] valid email address ?
                    $contact->email = $row[$request['email']];
                    $contact->subscribed = $import->contacts_subscribed;
                    $contact->save();

                    foreach($custom_fields as $key => $value) {
                    if($value) {
                            $field = Field::where('name', $key)->first();
                            $contact->fields()->attach($field, [ 'value' => $row[$value] ]);
                    } 
                    }
                }

            }

        }
    }
}