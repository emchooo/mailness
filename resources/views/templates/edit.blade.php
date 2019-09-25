@extends('layouts.main')

@section('content')
  
<div class="flex items-center justify-between mb-3">
  <h1 class="text-gray-700 text-2xl py-4" >Edit template: {{ $template->name }}</h1>
</div>

<form action="{{ route('templates.update', $template->id) }}" method="POST" >
<input type="hidden" name="_method" value="PUT">
@csrf   

<input type="text" name="name" value="{{ $template->name }}" class="border p-2 bg-gray-200" > 
@if($errors->has('name'))
			<div class="bg-red-100 border-l-4 border-orange-500 text-orange-700 p-2 mx-2" role="alert">
				<p>{{ $errors->first('name') }}</p>
			</div>
		@endif

<textarea name="content" id="" cols="30" rows="10" class="block bg-gray-200 p-2 m-2">{{ $template->content }}</textarea>
@if($errors->has('content'))
			<div class="bg-red-100 border-l-4 border-orange-500 text-orange-700 p-2 mx-2" role="alert">
				<p>{{ $errors->first('content') }}</p>
			</div>
		@endif

<input type="submit" value="Save" class="bg-blue-500 text-white px-3 py-2" >

</form>

@endsection