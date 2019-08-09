@extends('layouts.main')

@section('content')

<div class="flex items-center justify-between mb-3">
  <h1 class="text-gray-700 text-2xl py-4" >{{ $list->name }}</h1>
  <a href="{{ route('contacts.create', $list->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center" >Add contact</a>
</div>


<div class="border border-l-0 border-t-0 border-r-0 mb-5 pb-1" >
	<a href="#" class="pr-6" >Contacts</a>
	<a href="{{ route('fields.index', $list->id) }}" class="pr-6" >Fields</a>
	<a href="#">Settings</a>
</div>

<h1>Edit list</h1>

	<form method="POST" action="{{ route('lists.update', $list->id) }}" >
    <input type="hidden" name="_method" value="PUT">

		@csrf

		<input type="text" name="name" value="{{ $list->name }}" class="bg-gray-300 p-2 block" >

		<input type="submit" value="Save" class="bg-blue-500 py-2 px-4 rounded" >
		
	</form>


	<form action="{{ route('lists.delete', $list->id) }}" method="POST">
	<input type="hidden" name="_method" value="DELETE">

		@csrf	

		<input type="submit" value="DELETE" class="bg-red-500 py-2 px-4 rounded">
	</form>
		

@endsection