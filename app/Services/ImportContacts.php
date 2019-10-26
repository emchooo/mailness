<?php

namespace App\Services;

use App\Contact;
use App\Import;

class ImportContacts
{
    protected $file;

    public function __construct($file_id)
    {
        $import = Import::findOrFail($file_id);
        $file_path = storage_path( 'app/public/' . $import->path);
        
        $this->file = new \SplFileObject($file_path, 'r');
        $this->file->setFlags(\SplFileObject::READ_CSV);
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

    public function getFileFields()
    {
        return $this->file->current();
    }

    public function getListFields($lists)
    {
        return $lists->fields->pluck('name');
    }
}