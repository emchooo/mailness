@extends('layouts.main')

@section('content')

<div class="flex items-center justify-between mb-3">
  <h1 class="text-gray-700 text-2xl py-4" >{{ $list->name }}</h1>
  <a href="{{ route('contacts.create', $list->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center" >Add contact</a>
</div>

@include('includes.list_submenu')

<h1>Create new field</h1>

	<form method="POST" action="{{ route('fields.store', $list->id) }}" >
		@csrf

		<input type="text" name="name" class="bg-gray-300 p-2 my-2" placeholder="Field name" >
		@if($errors->has('name'))
        <div class="bg-red-100 border-l-4 border-orange-500 text-orange-700 p-2 mx-2" role="alert">
          <p>{{ $errors->first('name') }}</p>
        </div>
      @endif

		<input type="submit" value="Save" class="block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center " >
		
	</form>
		

@endsection