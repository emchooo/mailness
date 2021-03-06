@extends('layouts.main')

@section('content')

<div class="flex items-center justify-between mb-3">
  <h1 class="text-gray-700 text-2xl py-4" >{{ $list->name }}</h1>
  <a href="{{ route('contacts.create', $list->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center" >Add contact</a>
</div>

@include('includes.list_submenu')

<h3 class="text-xl pb-3 " >Map fields</h3>

@if($errors->has('email_field'))
			<div class="bg-red-100 border-l-4 border-orange-500 text-orange-700 p-2 mx-2" role="alert">
				<p>{{ $errors->first('email_field') }}</p>
			</div>
    @endif

<form action="{{ route('contacts.import.process', [ $list->id, $import_id ]) }}" method="POST" >

@csrf

  <div class="block mt-2">
    <label for="">Email</label>
    <select name="email" id="">
      <option value=""></option>
      @foreach($fileFields as $field)
        <option value="{{ $field }}" @if(stripos($field, 'email') !== false) selected="selected" @endif >{{ $field }}</option>
      @endforeach
    </select>
  </div>

    @foreach($listFields as $field)
      <div class="block mt-2">
        <label for="">{{ $field->name }}</label>
        <select name="{{ $field->slug }}" id="">
          <option value=""></option>
          @foreach($fileFields as $f)
            <option value="{{ $f }}" @if(stripos($field->slug, $f) !== false) selected="selected" @endif >{{ $f }}</option>
          @endforeach
        </select>
      </div>
    @endforeach

    <input type="submit" value="Save" class="px-4 py-2 bg-gray-500 mt-5" >

</form>


@endsection