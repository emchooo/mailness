<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Field;
use App\Http\Requests\ListStoreRequest;
use App\Http\Requests\ListUpdateRequest;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Jobs\SendConfirmSubscriptionEmail;
use App\Lists;
use Illuminate\Http\Request;

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
                    ->withCount(['contacts as contactCount'])
                    ->paginate(null, ['*'], 'listPage')
                    ->onEachSide(3)
                    // @todo Add the Required Parameters to add in
                    //pagination
                    ->appends($request->only([]));

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
        if (! $request->exists('double_opt_in')) {
            $request->request->add(['double_opt_in' => 0]);
        }

        $list = Lists::create($request->except(['__token']));

        $list->fields()->create([
            'name' => 'First name',
            'slug' => 'first_name',
        ]);

        $list->fields()->create([
            'name' => 'Last name',
            'slug' => 'last_name',
        ]);

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
        $contacts = Contact::where('list_id', '=', $lists->id)
                            ->where('subscribed', ! $request->subscribed)
                            ->orderBy('id', 'desc')
                            ->paginate(10);

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
        if (! $request->exists('double_opt_in')) {
            $request->request->add(['double_opt_in' => 0]);
        }

        $lists->update($request->except(['__token']));

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
        $contact = Contact::create([
            'email' => $request->email,
            'list_id'   => $list->id,
            'subscribed'    => $list->double_opt_in ? 0 : 1,
        ]);

        if ($request->fields) {
            foreach ($request->fields as $key => $value) {
                if ($value) {
                    $field = Field::find($key);
                    $contact->fields()->attach($field, ['value' => $value]);
                }
            }
        }

        if ($list->double_opt_in) {
            SendConfirmSubscriptionEmail::dispatch($contact);
        }

        return redirect()->to(route('lists.subscribe.success', $list->uuid));
    }

    public function subscribeSuccess(Lists $list)
    {
        return view('lists.subscribeSuccess', compact('list'));
    }

    public function subscribeConfirm($list_uuid, $contact_uuid)
    {
        $list = Lists::where('uuid', $list_uuid)->firstOrFail();

        $contact = Contact::where('list_id', $list->id)->where('uuid', $contact_uuid)->firstOrFail();

        $contact->setAsConfirmed();

        return view('lists.confirmed', ['contact' => $contact]);
    }
}
