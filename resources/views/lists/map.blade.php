@extends('layouts.main')

@section('content')

<div class="flex items-center justify-between mb-3">
  <h1 class="text-gray-700 text-2xl py-4" >{{ $list->name }}</h1>
  <a href="{{ route('contacts.create', $list->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center" >Add contact</a>
</div>

@include('includes.list_submenu')

<h3 class="text-xl pb-3 " >Map fields</h3>

<p class="text-gray-500 pb-3" >Fields from file</p>
<ul>
  @foreach($headers as $header)
    <li>{{ $header }}</li>
  @endforeach
</ul>

<p class="text-gray-500 py-3" >Fields from list</p>

<ul>
  @foreach($fields as $field)
    <li>{{ $field }}</li>
  @endforeach
</ul>

@endsection