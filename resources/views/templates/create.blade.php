@extends('layouts.main')

@section('content')

<script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>

  
<div class="flex items-center justify-between mb-3">
  <h1 class="text-gray-700 text-2xl py-4" >Create new template</h1>
</div>

<form action="{{ route('templates.store') }}" method="POST">
    @csrf

<input type="text" name="name" class="border bg-gray-300 mb-3" placeholder="Name" value="{{ old('name') }}" >
    @if($errors->has('name'))
			<div class="bg-red-100 border-l-4 border-orange-500 text-orange-700 p-2 mx-2" role="alert">
				<p>{{ $errors->first('name') }}</p>
			</div>
		@endif

<br>

<textarea name="content" id="editor" cols="30" rows="10" class="border bg-gray-300 border-1" >{{ old('content') }}</textarea>
<script>
    CKEDITOR.replace( 'content', {
		fullPage: true,
	});
</script>
    @if($errors->has('content'))
			<div class="bg-red-100 border-l-4 border-orange-500 text-orange-700 p-2 mx-2" role="alert">
				<p>{{ $errors->first('content') }}</p>
			</div>
		@endif


<input type="submit" value="Save" class="bg-blue-500 block text-white px-6 py-3 mt-4">

</form>

@endsection