<?php

namespace App\Http\Controllers;

use App\Field;
use App\Http\Requests\FieldStoreRequest;
use App\Lists;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($list_id)
    {
        $list = Lists::find($list_id);

        return view('fields.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($list_id)
    {
        $list = Lists::find($list_id);

        return view('fields.create', compact('list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($list_id, FieldStoreRequest $request)
    {
        // @todo add validation
        $field = new Field();
        $field->name = $request->name;
        $field->slug = Str::slug($request->name);
        $field->list_id = $list_id;
        $field->save();

        return redirect()->route('fields.index', $list_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($list_id, $field_id)
    {
        $list = Lists::find($list_id);
        $field = Field::find($field_id);

        return view('fields.edit', compact('list', 'field'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $list_id, $field_id)
    {
        // @todo validation
        $field = Field::find($field_id);
        $field->name = $request->name;
        $field->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($field_id)
    {
        $field = Field::find($field_id);
        $field->delete();

        return back();
    }
}
