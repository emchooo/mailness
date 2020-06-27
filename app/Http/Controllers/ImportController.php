<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportSaveRequest;
use App\Models\Import;
use App\Jobs\ImportContacts;
use App\Models\Lists;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportController extends Controller
{
    public function create(Lists $lists)
    {
        return view('lists.import', ['list' => $lists]);
    }

    public function store(Lists $lists, ImportSaveRequest $request)
    {
        $path = Storage::drive('public')->putFileAs('imports', $request->file('file'), Str::uuid().'.csv');

        $import = Import::create([
            'path' => $path,
            'list_id' => $lists->id,
            'contacts_subscribed' => $request->contacts_subscribed,
            'skip_duplicate' => $request->skip_duplicate,
        ]);

        return redirect()->route('contacts.import.map', ['lists' => $lists, 'id' => $import->id]);
    }

    public function getHeader($sheet): array
    {
        $header = $sheet->getRowIterator();

        $header->rewind();

        return $header->current()->toArray();
    }

    public function map(Lists $lists, $import_id)
    {
        $import = Import::findOrFail($import_id);

        $file_path = storage_path('app/public/'.$import->path);

        $reader = ReaderEntityFactory::createReaderFromFile($file_path);
        $reader->open($file_path);

        $sheet = $reader->getSheetIterator()->current();

        $header = $this->getHeader($sheet);
        $fileFields = $this->getHeader($sheet);
        $listFields = $import->list->fields;

        return view('lists.map', ['fileFields' => $fileFields, 'listFields' => $listFields, 'list' => $lists, 'import_id' => $import_id]);
    }

    public function importProcess(Request $request, Lists $lists, $import_id)
    {
        $mapped_fields = array_flip(array_filter($request->except('_token')));

        $import = Import::findOrFail($import_id);

        $file_path = storage_path('app/public/'.$import->path);

        $reader = ReaderEntityFactory::createReaderFromFile($file_path);
        $reader->open($file_path);

        $sheet = $reader->getSheetIterator()->current();

        $row_iterator = $sheet->getRowIterator();

        $row_iterator->rewind();

        $header = $row_iterator->current()->toArray();
        $count = 0;
        $delimeter = 250;

        $contacts = [];
        foreach ($sheet->getRowIterator() as $sheet_row) {
            $count++;

            $row = $sheet_row->toArray();

            if ($row == $header) {
                continue;
            }

            $contact = array_combine($header, $row);

            $new_contacts = [];
            foreach ($mapped_fields as $key => $value) {
                $new_contacts[$value] = $contact[$key];
                array_push($contacts, $new_contacts);
            }

            if ($count > $delimeter) {
                ImportContacts::dispatch($contacts, $lists->id, $import->id);
                $contacts = [];
                $count = 1;
            }
        }

        ImportContacts::dispatch($contacts, $lists->id, $import->id);

        $reader->close();

        return redirect()->route('lists.show', ['lists' => $lists]);
    }
}
