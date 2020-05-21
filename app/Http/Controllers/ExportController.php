<?php

namespace App\Http\Controllers;

use App\Lists;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Illuminate\Support\Str;

class ExportController extends Controller
{
    public function export(Lists $lists, $type = null)
    {
        $writer = WriterEntityFactory::createCSVWriter();
        $writer->openToBrowser(Str::slug($lists->name).'_contacts_'.$type.'.csv');

        $header = ['email'];
        $fields = $lists->fields->pluck('name')->each(function ($item) use (&$header) {
            $header[] = Str::slug($item);
        });

        $headerFromValues = WriterEntityFactory::createRowFromArray($header);
        $writer->addRow($headerFromValues);

        $allContacts = $this->getContacts($lists, $type);

        $allContacts->select('id', 'email', 'list_id')->with('fields')->chunk(10000, function ($contacts) use ($writer,$header) {
            $contacts->each(function ($contact) use ($writer,$header) {
                $values = $this->getFields($contact->fields, $header);
                $values['email'] = $contact->email;
                $rowFromValues = WriterEntityFactory::createRowFromArray($values);
                $writer->addRow($rowFromValues);
            });
        });

        $writer->close();
        exit;
    }

    public function getContacts($lists, $type)
    {
        if ($type == 'unsubscribed') {
            return $lists->unsubscribedContacts();
        }

        return $lists->contacts();
    }

    public function getFields($fields, $header)
    {
        $all_fields = array_fill_keys($header, '');

        foreach ($fields as $field) {
            $field_name = Str::slug($field->name);
            $all_fields[$field_name] = $field->pivot->value;
        }

        return $all_fields;
    }
}
