<?php

namespace App\Http\Controllers;

use App\Field;
use App\Lists;
use App\Import;
use App\Contact;
use App\Jobs\ImportFile;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\ImportContacts;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ImportSaveRequest;
use App\Http\Requests\ContactStoreRequest;
use App\Http\Requests\ContactUpdateRequest;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Lists $lists)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Lists $lists)
    {
        return view('contacts.create', ['list' => $lists]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactStoreRequest $request, Lists $lists)
    {
        $contactCreationArray = array_merge(
            $request->only(['email']),
            [
                'list_id' => $lists->id,
            ]
        );

        $contact = Contact::create($contactCreationArray);

        if ($request->fields) {
            foreach ($request->fields as $key => $value) {
                if ($value) {
                    $field = Field::find($key);
                    $contact->fields()->attach($field, ['value' => $value]);
                }
            }
        }

        return redirect()->route('lists.show', $lists->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Lists $lists, Contact $contact)
    {
        return view('contacts.show', ['contact' => $contact]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Lists $lists, Contact $contact)
    {
        return view('contacts.edit', ['list' => $lists, 'contact' => $contact]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(ContactUpdateRequest $request, Lists $lists, Contact $contact)
    {
        $contact->fields()->detach();
        if ($request->fields) {
            foreach ($request->fields as $key => $value) {
                if ($value) {
                    $field = Field::find($key);
                    $contact->fields()->attach($field, ['value' => $value]);
                }
            }
        }
        $contact->email = $request->email;
        $contact->save();

        return view('contacts.show', ['list' => $lists, 'contact' => $contact]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('lists.index');
    }

    public function export(Lists $lists)
    {
        $contacts = Contact::where('list_id', $lists->id)->get();

        if ($contacts->isEmpty()) {
            return redirect()
                    ->route('lists.edit', $lists)
                    ->with('error', 'No Contacts Found');
        }

        $all_fields = array_keys($contacts->toArray()[0]);

        foreach ($lists->fields as $field) {
            $all_fields[] = strtolower($field->name);
        }

        $file = fopen('php://output', 'w');
        fputcsv($file, $all_fields);
        foreach ($contacts as $row) {
            $data = [];
            $row_array = $row->toArray();
            foreach ($lists->fields as $field) {
                $custom_field_value = $row->getFieldValue($field->id);
                $custom_field_value ? $data[] = $custom_field_value : $data[] = '';
            }
            fputcsv($file, array_merge($row_array, $data));
        }
        fclose($file);

        header('Content-Disposition: attachment; filename="contacts.csv"');
        header('Cache-control: private');
        header('Content-type: application/force-download');
        header("Content-transfer-encoding: binary\n");
        exit;
    }

    public function import(Lists $lists)
    {
        return view('lists.import', ['list' => $lists]);
    }

    public function importSave(Lists $lists, ImportSaveRequest $request)
    {
        $path = Storage::drive('public')->putFileAs('imports', $request->file('file'), Str::uuid().'.csv');

        $import = new Import();
        $import->path = $path;
        $import->list_id = $lists->id;
        $import->contacts_subscribed = $request->contacts_subscribed;
        $import->skip_duplicate = $request->skip_duplicate;
        $import->save();

        return redirect()->route('contacts.import.map', ['lists' => $lists, 'id' => $import->id]);
    }

    public function map(Lists $lists, $import_id)
    {
        $import = new ImportContacts($import_id);

        $fileFields = $import->getFileFields();

        $listFields = $import->getListFields($lists);

        return view('lists.map', ['fileFields' => $fileFields, 'listFields' => $listFields, 'list' => $lists, 'import_id' => $import_id]);
    }

    public function importProcess(Request $request, Lists $lists, $import_id)
    {
        $importer = new ImportContacts($import_id);

        if (! $request->email) {
            return back()->withErrors(['email_field' => 'Email field is empty']);
        }

        if (! $importer->isEmailFieldsValidEmailAddress($request)) {
            return back()->withErrors(['email_field' => 'Email field is not valid']);
        }

        ImportFile::dispatch($request->except(['_token']), $lists, $import_id);

        return redirect()->route('lists.show', $lists->id);
    }
}
