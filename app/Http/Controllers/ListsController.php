<?php

namespace App\Http\Controllers;

use App\Field;
use App\Lists;
use App\Contact;
use Illuminate\Http\Request;
use App\Http\Requests\ListStoreRequest;
use App\Http\Requests\ListUpdateRequest;
use App\Http\Requests\ContactStoreRequest;

class ListsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lists = Lists::orderBy('id', 'desc')->paginate(10);
        return view('lists.index', compact('lists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('lists.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ListStoreRequest $request)
    {
        $list = new Lists();
        $list->name = $request->name;
        $list->save();

        return redirect()->route('lists.show', $list->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lists  $lists
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Lists $lists)
    {
        // @todo refactor this
        if($request->subscribed) {
            $contacts = Contact::where('list_id', $lists->id)->inactive()->orderBy('id', 'desc')->paginate(10);
        } else {
            $contacts = Contact::where('list_id', $lists->id)->active()->orderBy('id', 'desc')->paginate(10);
        }
        return view('lists.show', [ 'list' => $lists, 'contacts' => $contacts, 'subscribed' => $request->subscribed ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lists  $lists
     * @return \Illuminate\Http\Response
     */
    public function edit(Lists $lists)
    {
        return view('lists.edit', [ 'list' => $lists ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lists  $lists
     * @return \Illuminate\Http\Response
     */
    public function update(ListUpdateRequest $request, Lists $lists)
    {
        $lists->name = $request->name;
        $lists->save();
    
        return redirect(route('lists.show', $lists->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lists  $lists
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lists $lists)
    {
        // @todo who can delete list ?
       $lists->contacts()->delete(); 
       $lists->delete();

       return redirect()->route('lists.index');
    }

    /**
     * Subscribe form
     * 
     * @param \App\Lists $lists
     */
    public function subscribe(Lists $lists)
    {
        return view('lists.subscribe', [ 'list' => $lists ]);
    }

    /**
     * Save subscribe
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param \App\Lists $lists
     */
    public function subscribeStore(ContactStoreRequest $request, Lists $lists)
    {
        // @todo refator this with ContactController@store and update
        $contact = Contact::where('email', $request->email)->where('list_id', $lists->id)->first();
        if(! isset($contact) ) {
            $contact = new Contact();
            $contact->email = $request->email;
            $contact->list_id = $lists->id;
            $contact->save();

            if($request->fields) {
                foreach($request->fields as $key => $value) {
                    if($value) {
                        $field = Field::find($key);
                        $contact->fields()->attach($field, [ 'value' => $value ]);
                    }
                }
            }
        }

        return redirect()->to(route('lists.subscribe.success', $lists->id));
    }

    /**
     * 
     */
    public function subscribeSuccess()
    {
        return view('lists.subscribeSuccess');
    }
}
