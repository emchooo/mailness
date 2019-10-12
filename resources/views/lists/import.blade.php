@extends('layouts.main')

@section('content')

<div class="flex items-center justify-between mb-3">
  <h1 class="text-gray-700 text-2xl py-4" >{{ $list->name }}</h1>
  <a href="{{ route('contacts.create', $list->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center" >Add contact</a>
</div>

@include('includes.list_submenu')

<h3>Import</h3>

<form action="{{ route('contacts.import.save', $list->id) }}" enctype="multipart/form-data" method="POST" class="mt-10" >
    @csrf 

    <input type="file" name="file">

    @if($errors->has('file'))
			<div class="bg-red-100 border-l-4 border-orange-500 text-orange-700 p-2 mx-2" role="alert">
				<p>{{ $errors->first('file') }}</p>
			</div>
    @endif
    
    <h2 class="mt-4">Contacts status</h2>
    <div class="block">
      <input type="radio" name="status" value="subscribed" checked > Subscribed 
      <br>
      <input type="radio" name="status" value="unsubscribed"> Unsubscribed
    </div>

    <h2 class="mt-4" >What if a contact already exists in the list?</h2>
    <div class="block">
      <input type="radio" name="duplicate_contact" value="skip" checked > Skip
      <br>
      <input type="radio" name="duplicate_contact" value="update"> Update
    </div>

    <div class="block mt-5">
      <input type="submit" value="Import" class="bg-blue-500 py-2 px-4 rounded" >
    </div>

</form>

@endsection