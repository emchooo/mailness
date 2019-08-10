@extends('layouts.main')

@section('content')

<div class="flex items-center justify-between mb-3">
  <h1 class="text-gray-700 text-2xl py-4" >{{ $contact->list->name }}</h1>
  <a href="{{ route('contacts.create', $contact->list->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center" >Add contact</a>
</div>




<h1>Contact {{ $contact->email }}</h1>

@foreach($contact->list->fields as $field)
	{{ $field->name }}
@endforeach

<br>
<br>

@foreach($contact->fields as $f)
	{{ $f->name }} : {{ $f->pivot->value }}
@endforeach
		

@endsection