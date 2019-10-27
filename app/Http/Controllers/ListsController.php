<?php

namespace App\Http\Controllers;

use App\Field;
use App\Lists;
use App\Contact;
use Illuminate\Http\Request;
use App\Http\Requests\ListStoreRequest;
use App\Http\Requests\ListUpdateRequest;
use App\Http\Requests\StoreSubscriptionRequest;

class ListsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lists = Lists::query()
                    ->latest('id')
                    ->paginate(10)
                    ->onEachSide(3)
                    ->appends($request->all());

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
        $double_opt_in = $request->double_opt_in ? $request->double_opt_in : 0;
        $list = Lists::create([ 'name' => $request->name, 'double_opt_in' => $double_opt_in ]);

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
        if ($request->subscribed) {
            $contacts = Contact::where('list_id', $lists->id)->inactive()->orderBy('id', 'desc')->paginate(10);
        } else {
            $contacts = Contact::where('list_id', $lists->id)->active()->orderBy('id', 'desc')->paginate(10);
        }

        return view('lists.show', ['list' => $lists, 'contacts' => $contacts, 'subscribed' => $request->subscribed]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lists  $lists
     * @return \Illuminate\Http\Response
     */
    public function edit(Lists $lists)
    {
        return view('lists.edit', ['list' => $lists]);
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
        $double_opt_in = $request->double_opt_in ? $request->double_opt_in : 0;

        $lists->double_opt_in = $double_opt_in;
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
     * Subscribe form.
     *
     * @param \App\Lists $lists
     */
    public function subscribe(Lists $list)
    {
        return view('lists.subscribe', ['list' => $list]);
    }

    /**
     * Save subscribe.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param \App\Lists $lists
     */
    public function subscribeStore(StoreSubscriptionRequest $request, Lists $list)
    {
        $contactCreationArray = array_merge(
            $request->only(['email']),
            [
                'list_id' => $list->id,
                'subscribed' => $list->double_opt_in ? 0 : 1
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

        if($list->double_opt_in) {
            // send confirmation email
        }

        return redirect()->to(route('lists.subscribe.success', $list->uuid));
    }

    public function subscribeSuccess(Lists $list)
    {
        return view('lists.subscribeSuccess', compact('list'));
    }
}
