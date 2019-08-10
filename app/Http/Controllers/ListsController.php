<?php

namespace App\Http\Controllers;

use App\Lists;
use Illuminate\Http\Request;
use App\Http\Requests\ListUpdateRequest;
use App\Http\Requests\ListStoreRequest;

class ListsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lists = Lists::orderBy('id', 'desc')->get();
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
    public function show(Lists $lists)
    {
        return view('lists.show', [ 'list' => $lists ]);
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
}
