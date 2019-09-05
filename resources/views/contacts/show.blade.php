@extends('layouts.main')

@section('content')

<div class="flex items-center justify-between mb-3">
  <h1 class="text-gray-700 text-2xl py-4" >{{ $contact->list->name }}</h1>
  <a href="{{ route('contacts.create', $contact->list->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center" >Add contact</a>
</div>


<ul class="mt-4" >
  <li class="mt-2" ><b>Email:</b> {{ $contact->email }}</li>
@foreach($contact->fields as $f)
	<li class="mt-2" ><b>{{ $f->name }}</b>: {{ $f->pivot->value }}</li>
@endforeach
</ul>
		

@endsection