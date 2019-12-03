@extends('layouts.main')

@section('content')

<div class="flex items-center justify-between mb-3">
  <h1 class="text-gray-700 text-2xl py-4" >{{ $contact->list->name }}</h1>
  <a href="{{ route('contacts.create', $contact->list->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center" >Add contact</a>
</div>


<ul class="mt-4 mb-10" >
  <li class="mt-2" ><b>Email:</b> {{ $contact->email }}</li>
@foreach($contact->fields as $f)
	<li class="mt-2" ><b>{{ $f->name }}</b>: {{ $f->pivot->value }}</li>
@endforeach
</ul>

<form action="{{ route('contacts.unsubscribe', [ $contact->list->id, $contact->id ] ) }}" method="POST" >
@csrf
  <input type="submit" value="Unsubscribe" class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center" >
</form>

<p>Campaings recived:</p>
<ul class="mb-5" >

    @foreach( $contact->sent as $sent )
    <li><a href="{{ route('campaigns.report', [ $sent->campaign['id'] ]) }}">{{ $sent->campaign['subject'] }}</a></li>
    @endforeach
</ul>

		
<a href="{{ route('contacts.edit', [ $contact->list->id, $contact->id ]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center" >Edit</a>

@endsection